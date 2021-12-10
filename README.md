# HealthCareMining 
The main objective of this project is to develop an informative website that converts the given unstructured data from user written **COVID-19** related posts that were scraped from various forums like ( [MedHelp.com](https://www.medhelp.org/forums/Coronavirus/show/2203), [Patient.info](https://patient.info/coronavirus-covid-19), [Mayoclinic.org](https://www.mayoclinic.org/) ) into properly structured data and developing a parameter based search interface to provide the relevant posts, symptoms and treatments (if any) based on the user's search. 
### Problems
* Unstructured Health-Related User Experience posts.
* All the User Experience posts are spread across several forums
* No website specifically curated for COVID-19 related information
### Assumptions
The majority of the user written posts
```
➔ Will not contain any non-contextual information.
```
```
➔ The information described by the user is COVID-19 related.
```
### Web Scraping
**Aim:** to scrape and extract COVID-19 related data from mulitple forums.<br>
**Forums from which the data is scraped**
* MedHelp
* Patient.info
* Mayoclinic.org
* Livescience.com
* Camh.ca <br>
We have used python's scrapy framework for web scraping.

### Unified Medical Language System
```
Semantic Network
It comprises of 135 broad categories and has 54 relations among these categories.
```
```
Specialist Lexicon and Tools
Uses lexical information and programs for the language processing.
```
```
Metathesaurus
It has over one million bio-medical concepts from over 100 sourses.
```

### MetaMap
➔ Built by National Library of Medicine (NLM).<br>
➔ Highly configurable.<br>
➔ It used computational-linguistic and Natural Language Processing techniques.<br>
➔ Java Web API and Online Interactive Interface available.

### Ontologies and indexing
* Will create Symptom, Treatment and symp weight ontology cores in apache solr .
* The output of metamap will be inserted into this solr database along with page rank weight column.
* Related symptoms will be extracted based on the symp weights.
* Related post links will be extracted based on tht page rank we have created using the algorithm mentioned in the project.
* 
### SympGraph
* A graph with symptoms as nodes and co-occurence relations between these symptoms as edges.
* The symptoms from various posts/forums written by different patients are used to generate this graph.
* It is used for symptom expansion.

### References
* Bello, Fernando López, et al. "From medical records to research papers: a literature analysis pipeline for supporting medical genomic diagnosis processes." Informatics in Medicine Unlocked 15 (2019): 100181. 
* https://www.medhelp.org/forums/Coronavirus/show /2203
* A. Aronson. MetaMap - A Tool For Recognizing UMLS Concepts in Text. 2018. https://metamap.nlm.nih.goV
* López-Ubeda, Pilar, et al. "Filtering and reranking using MetaMap named entities recognizer." TREC. 2018.
* Sondhi, Parikshit, et al. "SympGraph: a framework for mining clinical notes through symptom relation graphs." Proceedings of the 18th ACM SIGKDD international conference on Knowledge discovery and data mining. 2012.
* F. Wang. Healthcare Data Mining with Matrix Models. https:// astro.temple.edu/ tua87106/KDD16_tut_part1.pdf

> :warning: This is a general readme file that gives a brief understanding of the work we have done in this project and explains the technical information to get an understaning of this project. If you want to install, execute instructions or get detailed understanding of the work we have done, please refer to repective readme files present in each module.
> The scaraped data taken for the medical forums are stored in HealthCareMining/ScraperFiles/stage1_scrapping directory.
> The structured medical data extracted using MetaMap are stored in HealthCareMining/MetaMapAnnotator/resources directory.
