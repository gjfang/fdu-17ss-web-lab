const countries = [
    { name: "Canada", continent: "North America", cities: ["Calgary","Montreal","Toronto"], photos: ["canada1.jpg","canada2.jpg","canada3.jpg"] },
    { name: "United States", continent: "North America", cities: ["Boston","Chicago","New York","Seattle","Washington"], photos: ["us1.jpg","us2.jpg"] },
    { name: "Italy", continent: "Europe", cities: ["Florence","Milan","Naples","Rome"], photos: ["italy1.jpg","italy2.jpg","italy3.jpg","italy4.jpg","italy5.jpg","italy6.jpg"] },
    { name: "Spain", continent: "Europe", cities: ["Almeria","Barcelona","Madrid"], photos: ["spain1.jpg","spain2.jpg"] }
];

window.onload= function () {

    for (var i = 0; i < countries.length; i++) {

        let MAIN=document.getElementById("main");
        let item=document.createElement("div");
        item.setAttribute("class","item");

        let h2_0 = document.createElement("h2");
        h2_0.innerText = countries[i].name;
        let p0 = document.createElement("p");
        p0.innerHTML = countries[i].continent;
        item.appendChild(h2_0);
        item.appendChild(p0);



        let h3_0 = document.createElement("h3");
        h3_0.innerHTML = "Cities";
        let ul=document.createElement("ul");
        for (let j=0;j<countries[i].cities.length;j++) {
            let li=document.createElement("li");
            li.innerHTML=countries[i].cities[j];
            ul.appendChild(li);
        }
        let inner_box_0=document.createElement("div");
        inner_box_0.setAttribute("class","inner-box");
        inner_box_0.appendChild(h3_0);
        inner_box_0.appendChild(ul);
        item.appendChild(inner_box_0);

        let h3_1 = document.createElement("h3");
        h3_1.innerHTML = "Related Photos";
        let inner_box_1=document.createElement("div");
        inner_box_1.setAttribute("class","inner-box");
        inner_box_1.appendChild(h3_1);
        for (let k=0;k<countries[i].photos.length;k++){
            let img=document.createElement("img");
            img.setAttribute("class","photo");
            img.src="images/"+countries[i].photos[k];
            inner_box_1.appendChild(img);
        }
        item.appendChild(inner_box_1);
        let button=document.createElement("button");
        button.setAttribute("class","button");
        button.innerHTML="visit";
        item.appendChild(button);
        MAIN.appendChild(item);
    }
};

