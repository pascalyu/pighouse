/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../../css/action/action.css');
$(document).ready(function () {
    changeDisplayAmountsButtons();
    $("#add-amount-to-house-button").on("click", function () {
        callChangeAmountAction($(this).data("href"), successAddAmount);
    });

    $("#substract-amount-to-house-button").on("click", function () {
        callChangeAmountAction($(this).data("href"), successSubstractAmount);
    });
    $("#amount_to_commit").on("input",function(){
        changeDisplayAmountsButtons();
    });
});

function changeDisplayAmountsButtons(){
 
    $("#new-amount-add-display").html(parseFloat($("#house_amount_value").val())+parseFloat($("#amount_to_commit").val()));
    $("#new-amount-substract-display").html(parseFloat($("#house_amount_value").val())-parseFloat($("#amount_to_commit").val()));
}
function callChangeAmountAction(href, callbackSuccess) {
    $.ajax({
        type: "get",
        dataType: "json",
        url: href,
        data: {amount: parseFloat($("#amount_to_commit").val()), house_id: $("#house_id").val()},
        success: function (response) {
            console.log(response);
            callbackSuccess(response);
        },
        error: function (response) {
            console.log(response);
        }
    });

}

function successAddAmount(data) {
    if (data.amount_saved) {
        addAmount($("#amount_to_commit").val());
        addActionRow(JSON.parse(data['action_entity']));
    }
}

function successSubstractAmount(data) {
    if (data.amount_saved) {
        substractAmount($("#amount_to_commit").val());
        addActionRow(JSON.parse(data['action_entity']));
    }
}

function addActionRow(actionEntity) {
    actionsTable = document.getElementById("action-historic");
    row = actionsTable.insertRow(0);
    $(row).attr("align","center");
    columnsCorrespondance = getColumnsCorrespondance();
    Object.keys(columnsCorrespondance).forEach(function (index) {
        row.insertCell(columnsCorrespondance[index]).innerHTML = actionEntity[index];
    });
    $(row).find("td:eq("+columnsCorrespondance['amount']+")").attr("class",actionEntity['colorClass']);
     $(row).hide();
     $(row).fadeToggle();
}
function addColorClassToAmountCell(classColor,row){
     columnsCorrespondance = getColumnsCorrespondance();
    Object.keys(columnsCorrespondance).forEach(function (index) {
        if(index=="amount");
    });
    
}
function getColumnsCorrespondance() {
    var result = {
        "pig": 0,
        "amount": 1,
        "date": 2,
       };
    return result;
}
function addAmount(value) {
    $("#house_amount_value").val(parseFloat($("#house_amount_value").val()) + parseFloat(value));
}
function substractAmount(value) {
    $("#house_amount_value").val(parseFloat($("#house_amount_value").val()) - parseFloat(value));
}

