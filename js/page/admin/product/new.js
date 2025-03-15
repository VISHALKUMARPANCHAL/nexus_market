document.getElementById("img").addEventListener("change", function(event) {
    let fileListDiv = document.getElementById("fileList");
    fileListDiv.innerHTML = "";

    let files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        let label = document.createElement("label");
        let radio = document.createElement("input");
        radio.type = "radio";
        radio.name = "catalog_product[main_image]";
        radio.value = files[i].name;
        label.appendChild(radio);
        label.appendChild(document.createTextNode(" " + files[i].name));
        fileListDiv.appendChild(label);
        fileListDiv.appendChild(document.createElement("br"));
    }
});