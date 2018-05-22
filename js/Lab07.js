
var device=document.getElementById("device");
var device_2=document.getElementById("device_2");

var select_one=document.getElementById("Select one");
var create_table=document.getElementById("Create_table");
var delete_row=document.getElementById("Delete row");
var delete_table=document.getElementById("Delete table");
var for_create=document.getElementById("for_create_table");
var for_add_row=document.getElementById("for_add_row");

var table_name=document.getElementById("Table_Name");
var columns_numbers=document.getElementById("Columns_Numbers");
var div_for_attr=document.getElementById("for_attr");
var div_for_attr_2=document.getElementById("for_attr_2");
var commit_button=document.getElementById("commit");

var for_table=document.getElementById("for_table");
var tr_for_th=document.getElementById("for_th");

var name_of_table;
var numbers_of_columns;
var table_list=[];
var table__table=[];
window.onload=function (ev) {

    device.onchange=function (ev1) {
        change();
    };

    columns_numbers.onfocus=function (ev1) {
        numOfAttr();
    };
    device_2.onchange=function (ev1) {
        change_2();
    };

};

function Table(id,numOfCol){

    this.id = id;
    this.numOfCol=numOfCol;
    this.getId = function(){
        return this.id;
    };
    this.getNum=function () {
        return this.numOfCol;
    };
    this.tr=[];

}



function change(){
    if (device.value==="0"){
        hide(commit_button);
        hide(div_for_attr);
        hide(div_for_attr_2);
    }
    if (device.value==="1"){
        for_table.innerHTML="";
        show(for_create);
        div_for_attr_2.innerHTML="";
        div_for_attr.innerHTML="";
        numOfAttr();
        commit_button.onclick=function (ev1) {

            select2(table_name.value);
            table(table_name.value,columns_numbers.value);
            table_name.value="";
            columns_numbers.value="";
            hide(for_create);
            hide(div_for_attr);
            hide(commit_button);

        }
    }
    else if (device.value==="2"){
        hide(for_create);
        hide(div_for_attr);
        show(commit_button);
        fill_td();
        commit_button.onclick=function (ev) {
            add_row();
            for (let i=0;i<(table_list[device_2.selectedIndex-1]).getNum();i++){
                document.getElementById ((table_list[device_2.selectedIndex-1]).getId()+"fill_td"+i).value="";
            }


        }

    }
    else if (device.value==="3"){
        show(commit_button);
        hide(div_for_attr);
        div_for_attr_2.innerHTML="";
        fill_delete();
        commit_button.onclick=function (ev) {
        DeleteRow();
        for (let i=0;i<table_list[device_2.selectedIndex-1].getNum();i++)
        {
           document.getElementById( table_list[device_2.selectedIndex-1].getId()+"fill_delete"+i).value="";
        }
        }


    }
    else if (device.value==="4"){
        show(commit_button);
        commit_button.onclick=function (ev) {
        deleteTable();
        }
    }
    else{}

}
function change_2() {
       if (device_2.value==="0"){
           for_table.innerHTML="";
           device.value="0";

       }
       else{
           for_table.innerHTML="";
           device.value="0";
          div_for_attr.innerHTML="";
          div_for_attr_2.innerHTML="";
             for_table.appendChild(table__table[device_2.selectedIndex-1]);

       }

}


function select2(name){
    let option=document.createElement("option");
    option.innerText=name;
    option.value=name;
    option.setAttribute("value",name);
    device_2.appendChild(option);
    option.selected=true;
}



function numOfAttr(){
    show(div_for_attr);
    columns_numbers.onchange=function (ev) {
        if (div_for_attr.children.length!==columns_numbers.value){
            div_for_attr.innerHTML="";
            for (let i=0;i<columns_numbers.value;i++){
                let attr=document.createElement("input");
                attr.setAttribute("placeholder","Attribute");
                attr.setAttribute("id",table_name.value+"_attr_"+i);
                div_for_attr.appendChild(attr);
            }
            show(commit_button);

        }
    };
}

function table(id,numOfCol){

    id=new Table(id,numOfCol);
    table_list[table_list.length]=id;
    let table=document.createElement("table");
    let tr=document.createElement("tr");
      table.setAttribute("id",table_list[device_2.selectedIndex-1].getId()+"__");
    for (let j=0;j<id.getNum();j++){
        let th=document.createElement("th");
        th.innerText=document.getElementById(id.getId()+"_attr_"+j).value;
        tr.appendChild(th);
        table_list[table_list.length-1].tr[j]=th.innerText;
    }
    table.appendChild(tr);
    table__table[table__table.length]=table;
    for_table.appendChild(table__table[device_2.selectedIndex-1]);


}

function deleteTable() {
    let num=device_2.selectedIndex-1;
    table__table.splice(device_2.selectedIndex-1,1);
    table_list.splice(device_2.selectedIndex-1,1);
    device_2.options.remove(device_2.selectedIndex);
    device_2.selectedIndex=num;



}
function fill_delete() {

    for (let i=0;i<table_list[device_2.selectedIndex-1].getNum();i++){
        let attr_2=document.createElement("input");
        attr_2.setAttribute("placeholder",(table_list[device_2.selectedIndex-1].tr[i]));
        attr_2.setAttribute("id",table_list[device_2.selectedIndex-1].getId()+"fill_delete"+i);
        div_for_attr_2.appendChild(attr_2);
    }
}
function DeleteRow() {
    var myTable = table__table[device_2.selectedIndex-1];
   var N=0;
    for(var i=1,rows=myTable.rows.length; i<rows; i++){
        for(var j=0,cells=myTable.rows[i].cells.length; j<cells; j++){
            if (myTable.rows[i].cells[j].innerText===document.getElementById(table_list[device_2.selectedIndex-1].getId()+"fill_delete"+j).value||document.getElementById(table_list[device_2.selectedIndex-1].getId()+"fill_delete"+j).value==="")
            {
               N++;
            }

        }
        if (N===myTable.rows[i].cells.length) {
            table__table[device_2.selectedIndex-1].deleteRow(i);
        }
    }



}

function fill_td(){

    for (let i=0;i<table_list[device_2.selectedIndex-1].getNum();i++){
        let attr_2=document.createElement("input");
        attr_2.setAttribute("placeholder",(table_list[device_2.selectedIndex-1].tr[i]));
        attr_2.setAttribute("id",table_list[device_2.selectedIndex-1].getId()+"fill_td"+i);
        div_for_attr_2.appendChild(attr_2);
        }


}
function add_row(){
    let tr=document.createElement("tr");
    for (let i=0;i<table_list[device_2.selectedIndex-1].getNum();i++){
        let td=document.createElement("td");
        td.innerText=document.getElementById(table_list[device_2.selectedIndex-1].getId()+"fill_td"+i).value;
        tr.appendChild(td);
    }
   table__table[device_2.selectedIndex-1].appendChild(tr);
}


function show(obj){
    obj.style.display="inline";
}
function hide(ele){
    ele.style.display="none";
}


function  clear(columns_numbers,table_name) {
    for (let i=0;i<columns_numbers.value;i++){
        document.getElementById(table_name.value+"fill_td"+i).value="";
    }

}