const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault(); //prevent from form submitting
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest(); 
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = ""; //message inserts/updates into DB *NB: not on screen
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form); //creating new form data
    xhr.send(formData);
}

chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active")
}
chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active")
}

setInterval(()=>{
    let xhr = new XMLHttpRequest(); //GET method for receiving data
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom();                    
                } else {
                    
                }
            }
        }
    }
    let formData = new FormData(form); //creating new form data
    xhr.send(formData);
}, 500); // run frequently every 500ms

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}