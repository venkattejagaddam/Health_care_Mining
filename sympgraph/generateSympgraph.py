import numpy as np
import matplotlib.pyplot as plt
import networkx as ntx
import csv
import os

def getSymptomsPostWise(postsNum):
	csvFile = '../sympgraph/MetamapUpdatedResult.csv'
	postSymptoms = {}
	symptoms = {}
	reverseMapSymptoms = {}
	indexSymptom = 0
	indexPost = 1
	with open(csvFile) as file:
		reader = csv.reader(file)
		header = next(reader, None)
		posts = [r for r in reader]

		for post in posts:
			idPost = post[0]
			idSymptom = post[1]
			nameSymptom = post[2]

			if idSymptom:
				if idPost not in postSymptoms:
					postSymptoms[idPost] = {"index": indexPost, "symptomList": [], "symptomNames": []}
					indexPost += 1

				if nameSymptom != 'Communicable Diseases' or 'Syndrome' in nameSymptom:
					postSymptoms[idPost]["symptomList"].append(idSymptom)
					postSymptoms[idPost]["symptomNames"].append(nameSymptom)

				if idSymptom not in symptoms:
					symptoms[idSymptom] = {"index": indexSymptom, "name": nameSymptom}
					reverseMapSymptoms[indexSymptom] = idSymptom
					indexSymptom += 1

				if postsNum != None and indexPost > postsNum:
					break

	return postSymptoms, symptoms, reverseMapSymptoms

def symptomMatrixPostWise(postSymptoms, symptoms):
	symptomMatrix = []

	for idPost, infoPost in postSymptoms.items():
		symps = [0 for i in range(len(symptoms))]

		for idSymptom in infoPost["symptomList"]:
			indexSymptomMat = symptoms[idSymptom]["index"]
			symps[indexSymptomMat] += 1

		symptomMatrix.append(symps)

	return symptomMatrix

def generateSympGraph(symptomMatrix, symptoms):
	symptomMatrix = np.array(symptomMatrix)
	shapeSymptomGraph = (len(symptoms), len(symptoms))
	symptomGraph = np.zeros(shapeSymptomGraph)

	for syms in symptomMatrix:
		syms = np.matrix(syms)
		symsGraph = np.matmul(syms.transpose(), syms)
		symptomGraph += symsGraph

	print(symptomGraph.shape)
	return symptomGraph

def getEdgesSympGraph(symptomGraph, reverseMapSymptoms,weight):
	listSymptomGraph = symptomGraph.tolist()
	listEdges = []

	for rows, syms in enumerate(listSymptomGraph):

		for cols in range(rows+1, len(listSymptomGraph)):
			src = reverseMapSymptoms[rows]
			des = reverseMapSymptoms[cols]
			weights = listSymptomGraph[rows][cols]
			# Draw Graph only Corona Virus Infections
			if weights >= weight:
				if des!= "C0018081":
					if des != "C0012634":
						if des != "C0037088":
							listEdges.append([src, des, weights])

	return listEdges

def generateGraph(listEdges, symptoms):
	graph = ntx.Graph()

	for edges in listEdges:
		graph.add_edge(symptoms[edges[0]]["name"], symptoms[edges[1]]["name"])
	print("number of nodes: ", graph.number_of_nodes())
	print("number of edges: ", graph.number_of_edges())

	option = {
		"with_labels": True,
		"node_color": "pink",
		"width": 0.5,
		"node_size": 40
	}

	ntx.draw_circular(graph, **option)
	l, r = plt.xlim()
	print(l)
	print(r)
	plt.xlim(l - 0.25, r + 0.1)
	plt.show()

def generateCSVSympGraph(listEdges):
	with open("SympGraph.csv", 'w') as writingFile:
		writr = csv.writer(writingFile)
		writr.writerow(["Source", "Destination", "Weight"])
		writr.writerows(listEdges)
		writingFile.close()
		

if __name__ == '__main__':
	postSymptoms, symptoms, reverseMapSymptoms = getSymptomsPostWise(None)
	symptomMat = symptomMatrixPostWise(postSymptoms, symptoms)
	symptomGraph = generateSympGraph(symptomMat, symptoms)
	weight = 1
	listEdges = getEdgesSympGraph(symptomGraph, reverseMapSymptoms,weight)
	generateCSVSympGraph(listEdges)
	print("Generation and Saving to CSV - Successful")

	postSymptoms, symptoms, reverseMapSymptoms = getSymptomsPostWise(60)
	symptomMat = symptomMatrixPostWise(postSymptoms, symptoms)
	symptomGraph = generateSympGraph(symptomMat, symptoms)
	weight = 3
	while weight <= 8 :
		listEdges = getEdgesSympGraph(symptomGraph, reverseMapSymptoms,weight)
		generateGraph(listEdges, symptoms)
		weight = weight + 1
	print("Visually Representing the Sympgraph - Successful")
	