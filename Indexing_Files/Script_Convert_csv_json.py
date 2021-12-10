import csv
import json
import os

def csv_to_json(csvFilePath, jsonFilePath):
    jsonArray = []
      
    #read csv file
    with open(csvFilePath, encoding='utf-8') as csvf: 
        #load csv file data using csv library's dictionary reader
        csvReader = csv.DictReader(csvf) 

        #convert each csv row into python dict
        for row in csvReader: 
            #add this python dict to json array
            jsonArray.append(row)
  
    #convert python jsonArray to JSON String and write to file
    with open(jsonFilePath, 'w', encoding='utf-8') as jsonf: 
        jsonString = json.dumps(jsonArray, indent=4)
        jsonf.write(jsonString)


files = [f for f in os.listdir('.') if os.path.isfile(f) and ("final_scrapping_metamap_data_updated_cahmx.csv" in f or "final_scrapping_metamap_data_updated_livescience.csv" in f \
    or "final_scrapping_metamap_data_updated_mayo.csv" in f or "final_scrapping_metamap_data_updated_medhelp.csv" in f or "final_scrapping_metamap_data_updated_patientinfo.csv" in f)]

for file in files:        
	csvFilePath = file
	jsonFilePath = file.replace(".csv",".json")
	csv_to_json(csvFilePath, jsonFilePath)
