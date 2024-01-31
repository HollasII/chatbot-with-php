const searchBar =  document.querySelector(".users .search input"),
searchBtn =  document.querySelector(".users .search button"),
usersList = document.querySelector(".users .user-list");

searchBtn.onclick = ()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
}

searchBar.onkeyup = ()=>{
    let searchTerm = searchBar.value

    let xhr = new XMLHttpRequest(); //GET method for receiving data
    xhr.open("POST", "php/search.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                console.log(data);
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("searchTerm=" + searchTerm);
}

setInterval(()=>{
    let xhr = new XMLHttpRequest(); //GET method for receiving data
    xhr.open("GET", "php/users.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }
    xhr.send();
}, 500); // run frequently every 500ms