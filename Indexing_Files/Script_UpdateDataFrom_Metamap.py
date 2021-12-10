import os
import csv
import json
import pandas


files = [f for f in os.listdir('.') if os.path.isfile(f) and ("cahmx.csv" in f or "livescience.csv" in f \
 or "mayo.csv" in f or "medhelp.csv" in f or "patientinfo.csv" in f)]

metamap_df = pandas.DataFrame()

with open('/Users/shivanipriya/Documents/GitHub/HealthCareMining/MetaMapAnnotator/resources/MetamapResult.csv') as scraper_file:
	metamap_df = pandas.read_csv(scraper_file)
	metamap_df = metamap_df.groupby(['PostLink']).agg(lambda x: tuple(x)).applymap(list).reset_index()

for file in files:
	print(file)
	df = pandas.read_csv(file)
	new_df = pandas.DataFrame(columns =["url","Drugs","Treatment","BodyParts"])
	for item in df.itertuples():
		link = item.PostLink
		for item in metamap_df.itertuples():
			if(link == item.PostLink):
				Treatment = item.TreatmentName
				Drugs = item.DrugName
				Body = item.BodypartName
				new_df.loc[len(new_df.index)] = [link,Drugs,Treatment,Body]

	df3 = pandas.concat([df, new_df], axis=1)
	df3 = df3.drop(["url"],axis =1)
	filename ="metamap_data_updated_" + file
	df3.to_csv(filename,index=False)
	del df3
	del new_df
	del df
	
