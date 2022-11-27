const btn = document.querySelector("button");


// btn.addEventListener("click", sendFile)

function sendFile(event) {
    event.preventDefault();
    let result
    const file = document.getElementById("formFile").files[0];
    let reader = new FileReader();
    reader.readAsText(file);
    reader.onload=function(){
        result =  JSON.stringify(reader.result)
        fetch('/test', { method: "POST", body: result});
        console.log(reader.result)
    }
    

    let formData = new FormData();
    formData.append("file", result);
    

}