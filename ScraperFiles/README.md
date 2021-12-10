# Scraping Using SCRAPY
* We have using scrapy tool to scrape the data from 5 websites which includes medhelp, mayoclinic, patientsinfo, live science, camhx.
* Data structure followed for scraping:
  Discussion{
    <br>url: (String)
    <br>title(String),
    <br>author(String),
    <br>content(String),
    <br>replies([Reply])
    <br>}
  <br>
  <br>Reply{
    <br>content(String),
    <br>sub_replies([String])
  <br>}
# Screenshot:
![image](https://user-images.githubusercontent.com/68100466/113780485-1f7e1a80-96e4-11eb-9388-878e52064c89.png)
