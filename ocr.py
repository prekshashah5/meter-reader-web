#!/usr/bin/env python
import cv2
import numpy as np
import imutils
import pytesseract
import mysql.connector
import io
from PIL import Image, ImageEnhance, ImageFilter
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'  # I am using Windows
    
def process_img(img):
    
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY) #convert to grey scale
    gray = cv2.bilateralFilter(gray, 11, 17, 17)
    edged = cv2.Canny(gray, 30, 200) #Perform Edge detection

    cnts = cv2.findContours(edged.copy(), cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
    cnts = imutils.grab_contours(cnts)
    cnts = sorted(cnts, key = cv2.contourArea, reverse = True)[:10]
    screenCnt = None

    # loop over our contours
    for c in cnts:
        # approximate the contour
        peri = cv2.arcLength(c, True)
        approx = cv2.approxPolyDP(c, 0.018 * peri, True)
        # if our approximated contour has four points, then
        # we can assume that we have found our screen
        if len(approx) == 4:
            screenCnt = approx
            break

    # Masking the part other than the "shape"
    mask = np.zeros(gray.shape,np.uint8)
    new_image = cv2.drawContours(mask,[screenCnt],0,255,-1,)
    new_image = cv2.bitwise_and(img,img,mask=mask)
    # Now crop
    (x, y) = np.where(mask == 255)
    (topx, topy) = (np.min(x), np.min(y))
    (bottomx, bottomy) = (np.max(x), np.max(y))
    cropped = gray[topx:bottomx+1, topy:bottomy+1]
    ################################################################################

    # Apply threshold the cropped area
    _, thresh = cv2.threshold(cropped, 0, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)

    # Find contours
    cnts = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
    cnts = imutils.grab_contours(cnts)

    # Get contour with maximum area
    c = max(cnts, key=cv2.contourArea)

    # Build a mask (same as the code above)
    mask = np.zeros(cropped.shape, np.uint8)
    new_cropped = cv2.drawContours(mask, [c], 0, 255, -1)
    new_cropped = cv2.bitwise_and(cropped, cropped, mask=mask)
    cv2.imwrite('tmp1.jpg',cropped)
    
    # Read the text in the "shape"
    image=cv2.imread('tmp1.jpg')    
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    #cv2.imwrite('tmp2.jpg',gray)
    blur = cv2.GaussianBlur(gray, (3,3), 0)
    #cv2.imwrite('tmp3.jpg',blur)
    thresh = cv2.threshold(blur, 0, 255, cv2.THRESH_BINARY_INV + cv2.THRESH_OTSU)[1]
    #cv2.imwrite('tmp4.jpg',thresh)
    # Morph open to remove noise and invert image
    kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (3,3))
    #cv2.imwrite('tmp5.jpg',kernel)
    opening = cv2.morphologyEx(blur, cv2.MORPH_OPEN, kernel, iterations=1)
    #cv2.imwrite('tmp6.jpg',opening)
    invert = 255 - opening
    #cv2.imwrite('tmp7.jpg',invert)
    # Perform text extraction
    #data = pytesseract.image_to_string(invert, lang="eng", config="--psm 10")
    data = pytesseract.image_to_string(invert, lang="eng", config="--psm 10 --oem 3 -c tessedit_char_whitelist=0123456789")
    if(len(data)<10):
        data = pytesseract.image_to_string(gray, lang="eng", config="--psm 10 --oem 3 -c tessedit_char_whitelist=0123456789")
    if(data[0]=='1'):
        data=data[1:]
    if(len(data)>8):
        data=data[:8]
    return data

def store_reading(data):
    file = open("output.txt","w")
    file.write(data)
    file.close()

def write_file(data, filename):
    # Convert binary data to proper format and write it on Hard Disk
    with open(filename, 'wb') as file:
        file.write(data)

def readBLOB(photo):
    try:
        connection = mysql.connector.connect(host='localhost',
                                         database='meter_reader',
                                         user='root',
                                         password='virati')
        cursor = connection.cursor()
        f = open("myFile.txt", "r")
        photo_id_str=f.readline()
        photo_id=int(photo_id_str)
        sql=("SELECT photo FROM photo_temp WHERE id =%d" % (photo_id))
        cursor.execute(sql)
        record = cursor.fetchall()
        for row in record:
            image = row[0]
            write_file(image, photo)

    except mysql.connector.Error as error:
        print("Failed to read BLOB data from MySQL table {}".format(error))

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
            print("MySQL connection is closed")

readBLOB("image.jpeg")
img = cv2.imread('image.jpeg')
data=process_img(img)
print(data)
store_reading(data)
