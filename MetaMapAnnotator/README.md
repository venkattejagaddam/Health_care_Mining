# MetaMap Annotator
This project uses MetaMap annotator Java API for annotating the web data scrapped by the scraper project.
The location of the CSV file containing the scrapped data, MetaMap options should be given in the class file.
The mmserver should be setup and running prior to running this project.

# Instructions
* Download MetaMap main release from [here](https://metamap.nlm.nih.gov/MainDownload.shtml)
* Download the MetMap Java API from [here](https://metamap.nlm.nih.gov/JavaApi.shtml)
* Extract and merge the *public_mm* folder of Java API into *public_mm* folder of main/full release. Make sure the duplicate files are ignored while merging.
* Run 

```
Using Windows Explorer find the "public_mm" directory extracted from the distribution archive. 
Click on the icon with the name "Install MetaMap". 
The dialog will display an input box with the label "Location of the Public MetaMap Directory:" filled in with the probable location where you've installed the distribution.
The next dialog will display one of possible locations where the Java Runtime Environment (JRE) is installed. 
This information is obtained from the Windows Registry which was set when one of the JREs was installed.
If the JRE location displayed is not the one you wish to use, change it by clicking the "Browse" button.
The next dialog will display a results of install.
If no errors are present in the log you can close the installation program by pressing the "Finish" button. After that, skip to the section on running MetaMap.

```

* Start and run the WSD, MedPost and MM servers in order in the separate command prompts.
```
G:\Projects\test\dfb\public_mm> bin\skrmedpostctl_start
G:\Projects\test\dfb\public_mm> bin\wsdserverctl_start
G:\Projects\test\dfb\public_mm> bin\mmserver14
G:\Projects\test\dfb\public_mm> bin\metamap14

```
* Note: You can find this process of running metamap from [here](https://metamap.nlm.nih.gov/Docs/README_win32.html#:~:text=Using%20Windows%20Explorer%20find%20the,you%27ve%20installed%20the%20distribution.)

* After starting all these
* Navigate to MetaMapAnnotator folder
* Run the .java file in eclipse/ any editor or run jar file using the following command in the command prompt:
```
C:\Users\UserName\Desktop\SWM_project\MetaMapAnnotator java -jar dist/MetaMapAnnotator.jar
```
* The input will be picked up from the neighbouring scraper/data folder which mentioned in MetaMapAnnotatorConfig.properties file.
* The output will be written to resources folder under MetMapAnnotator folder.

# Screenshots:
* Structured data:
![image](https://user-images.githubusercontent.com/68100466/113760896-abd01380-96cb-11eb-88c1-337eb43ddf76.png)
