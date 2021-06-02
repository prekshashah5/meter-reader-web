import mysql.connector
from fpdf import FPDF
from datetime import datetime

class PDF(FPDF):
    def header(self):

        #defining variables
        gst=0
        per_unit_charge=0
        prev_reading_id=0
        curr_reading_id=0
        units=0
        amount_without_gst=0
        total_amount=0
        bill_id=0
        billing_date=datetime.now()
        
        connection = mysql.connector.connect(host='localhost',
                                         database='meter_reader',
                                         user='root',
                                         password='virati')
        file1 = open('bill_details.txt', 'r')
        Lines = file1.readlines()
        cursor = connection.cursor()
        cid=int(Lines[0])
        bill_id=int(Lines[6])
        sql1=("select gst,per_unit_charge,logo from company_master where company_id=(select company_id from meter_master where customer_id=%d)" % (cid))
        cursor.execute(sql1)
        record = cursor.fetchall()
        for row in record:
            gst=row[0]
            per_unit_charge=row[1]
            logo=row[2]
            with open("company_logo.png", 'wb') as file:
                file.write(logo)
            # Logo
            self.image('company_logo.png', 83, 8, 50)
        self.ln(40)
        # Arial bold 15
        self.set_font('Arial','B',12)
        self.cell(190, 7, 'Customer Details', 1, 0, 'C')
        self.ln(10)
        self.set_font('Arial',size= 10)
        self.cell(200, 10, txt ="Username: " + Lines[1],ln = 1, align = 'L')
        self.cell(200, 10, txt ="First Name: " + Lines[2],ln = 1, align = 'L')
        self.cell(200, 10, txt ="Last Name: " + Lines[3],ln = 1, align = 'L')
        self.cell(200, 10, txt ="Mobile: " + Lines[4],ln = 1, align = 'L')
        self.cell(200, 10, txt ="Email: " + Lines[5],ln = 1, align = 'L')
        
        self.set_font('Arial','B',12)
        self.cell(190, 7, 'Bill Details', 1, 0, 'C')
        self.ln(10)
        
        
        self.set_font('Arial',size= 10)
        
        sql2=("SELECT curr_reading_id,prev_reading_id,units,amount_without_gst,total_amount,billing_date from bill_master where bill_id=%d" % (bill_id))
        cursor.execute(sql2) 
        record = cursor.fetchall()
        for row in record:
            curr_reading_id=int(row[0])
            prev_reading_id=int(row[1])
            units=int(row[2])
            amount_without_gst=int(row[3])
            total_amount=int(row[4])
            billing_date=row[5]
        sql3=("SELECT reading,date_time from reading_history where reading_id=%d" % (curr_reading_id))
        cursor.execute(sql3)
        record = cursor.fetchall()
        for row in record:
            curr_reading=int(row[0])
            curr_reading_date=row[1]        
            self.cell(200, 10, txt ="Current Reading: " + str(curr_reading),ln = 2, align = 'L')
            self.cell(200, 10, txt ="Current Reading Date: " + str(curr_reading_date.strftime('%d-%m-%Y')),ln = 2, align = 'L')

        sql4=("select reading,date_time from reading_history where reading_id=%d" % (prev_reading_id))
        cursor.execute(sql4)
        record = cursor.fetchall()
        for row in record:
            prev_reading=int(row[0])
            prev_reading_date=row[1]
            if(curr_reading_id==prev_reading_id):
                prev_reading=0
            self.cell(200, 10, txt ="Previous Reading: " + str(prev_reading),ln = 2, align = 'L')
            self.cell(200, 10, txt ="Previous Reading Date: " + str(prev_reading_date.strftime('%d-%m-%Y')),ln = 2, align = 'L')
            
        self.cell(200, 10, txt ="Units Used: " + str(units),ln = 2, align = 'L')
        self.cell(200, 10, txt ="Charge per Unit: " + str(per_unit_charge),ln = 2, align = 'L')
        self.cell(200, 10, txt ="Amount without GST: " + str(amount_without_gst),ln = 2, align = 'L')
        self.cell(200, 10, txt ="GST: " + str(gst)+"%",ln = 2, align = 'L')
        total_amount=amount_without_gst+amount_without_gst*15/100
        self.ln(10)
        self.set_font('Arial','B',14)
        self.cell(190, 7, 'Bill Amount :'+str(total_amount),ln = 2, align = 'C')

# Instantiation of inherited class
self = PDF()
self.alias_nb_pages()
self.add_page()
self.set_font('Times','', 12)
#for i in range(1, 41):
 #   pdf.cell(0, 10, 'Printing line number ' + str(i), 0, 1)
self.output('bill.pdf', 'F')
