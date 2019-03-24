/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#add-amount-to-house-button").on("click", function () {
        testAjax($(this).data("href"), successAddAmount);
    });
});
function test() {

}
function testAjax(test, callbackSuccess) {

    $.ajax({
        type: "get",
        dataType: "json",
        url: test,
        data: {amount: $("#amount_to_add").val(), house_id: $("#house_id").val()},
        success: function (response) {
           console.log(response);
            callbackSuccess(response);
        },
        error: function (response) {
            console.log(response);
            alert("pas nice");
        }
    });

}

function successAddAmount(data) {
  
    if (data.amount_saved) {
        addAmount($("#amount_to_add").val());
        addActionRow(JSON.parse(data['action_entity']));



    }


}

function addActionRow(actionEntity) {
    
    actionsTable = document.getElementById("action-historic");
    row = actionsTable.insertRow(0);
    row.insertCell(0).innerHTML= actionEntity.id;
    row.insertCell(1).innerHTML = actionEntity["actionType"];
    row.insertCell(2).innerHTML= actionEntity["amount"];
    row.insertCell(3).innerHTML = actionEntity["date"];
    row.insertCell(4).innerHTML= actionEntity["created_at"];
    row.insertCell(5).innerHTML = actionEntity["last_updated_at"];
    
    row.insertCell(5).innerHTML = actionEntity["deleted_at"];
    
    


// Add some text to the new cells:




}
function addAmount(value) {

    $("#house_amount_value").val(parseFloat($("#house_amount_value").val()) + parseFloat(value));
}
