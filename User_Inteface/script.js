  const searchInput = document.getElementById('search');
  const searchWrapper = document.querySelector('.wrapper');
  const resultsWrapper = document.querySelector('.results');
  

searchInput.addEventListener('keyup', () => {
    let results = [];
    let input = searchInput.value;
    
    if (input.length) {
      results = suggestions.filter((item) => {
        return item.toLowerCase().includes(input.toLowerCase());
      });
      
    searchWrapper.classList.add("active"); //show autocomplete box
    }
    if(input.length==0){
        resultsWrapper.classList.remove("active");
    }
    renderResults(results);
    let allList = resultsWrapper.querySelectorAll("li");
      for (let i = 0; i < allList.length; i++) {
          //adding onclick attribute in all li tag
          allList[i].setAttribute("onclick", "select(this)");
          searchWrapper.classList.remove("active");
      }
  });
  
  function renderResults(results) {
    if (!results.length) {
      return searchWrapper.classList.remove('show');
    }
  
    const content = results
      .map((item) => {
        return `<li>${item}</li>`;
      })
      .join('');
  
    searchWrapper.classList.add('show');
    resultsWrapper.innerHTML = `<ul>${content}</ul>`;
  }
  function select(element){
    let selectData = element.textContent;
    searchInput.value = selectData;
    
    return searchWrapper.classList.remove("show");
}

