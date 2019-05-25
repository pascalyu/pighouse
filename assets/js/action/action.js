/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../../css/action/action.css');

import { CountUp } from '../../../node_modules/countup.js/dist/CountUp.js';



$(document).ready(function () {
    changeDisplayAmountsButtons();
    $("#add-amount-to-house-button").on("click", function () {

        callChangeAmountAction($(this).data("href"), successAddAmount);
        addAmount($("#amount_to_commit").val());
    });

    $("#substract-amount-to-house-button").on("click", function () {

        callChangeAmountAction($(this).data("href"), successSubstractAmount);
        substractAmount($("#amount_to_commit").val());
    });
    $("#amount_to_commit").on("input", function () {
        changeDisplayAmountsButtons();
    });


});
$(document).on("click", ".remove-action", function () {
    confirmDeleteAction($(this).data("href"), $(this).parents("tr"));
});

function changeDisplayAmountsButtons() {

    $("#new-amount-add-display").html(parseFloat($("#house_amount_value").val()) + parseFloat($("#amount_to_commit").val()));
    $("#new-amount-substract-display").html(parseFloat($("#house_amount_value").val()) - parseFloat($("#amount_to_commit").val()));
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
function getIconsHtmlForCell(actionId) {
    return replaceToChangeByActionId("tochange", actionId);
}
function replaceToChangeByActionId(stringNeedle, actionId) {

    var re = new RegExp(stringNeedle, 'g');


    return $("#actions-cell-empty").html().replace(re, actionId);

}
function successAddAmount(data) {
    if (data.amount_saved) {
        addActionRow(JSON.parse(data['action_entity']));
    }
}

function successSubstractAmount(data) {
    if (data.amount_saved) {

        addActionRow(JSON.parse(data['action_entity']));
    }
}

function addActionRow(actionEntity) {

    var actionsTable = document.getElementById("action-historic");
    var row = actionsTable.insertRow(0);
    $(row).attr("align", "center");
    var columnsCorrespondance = getColumnsCorrespondance();
    Object.keys(columnsCorrespondance).forEach(function (index) {
        row.insertCell(columnsCorrespondance[index]).innerHTML = actionEntity[index];
    });

    var lastIndexOfColumns = columnsCorrespondance.lenght;
    row.insertCell(lastIndexOfColumns).innerHTML = getIconsHtmlForCell(actionEntity["id"]);
    $(row).find("td:eq(" + columnsCorrespondance['amount'] + ")").attr("class", actionEntity['colorClass']);
    $(row).hide();
    $(row).fadeToggle();
}


/*function addColorClassToAmountCell(classColor, row) {
 columnsCorrespondance = getColumnsCorrespondance();
 Object.keys(columnsCorrespondance).forEach(function (index) {
 
 });
 
 }*/
function getColumnsCorrespondance() {
    var result = {
        "pig": 0,
        "amount": 1,
        "date": 2,
    };
    return result;
}


const options = {
    decimalPlaces: 2,
    duration: 1,
    separator: '',
};
let demo = new CountUp('house_amount_value', $("#house_amount_value").html(), options);
if (!demo.error) {
    demo.start();
} else {
    console.error(demo.error);
}
function addAmount(value) {

    //var fromNumber=parseFloat($("#house_amount_value").html());
    var toNumber = parseFloat($("#house_amount_value").html()) + parseFloat(value);
    if (!demo.error) {
        demo.update(parseFloat(toNumber));
    } else {
        console.error(demo.error);
    }
    //$("#house_amount_value").html(parseFloat($("#house_amount_value").html()) + parseFloat(value));
}
function substractAmount(value) {


    var toNumber = parseFloat($("#house_amount_value").html()) - parseFloat(value);
    console.log(toNumber);
    if (!demo.error) {
        demo.update(parseFloat(toNumber));
    } else {
        console.error(demo.error);
    }
}

function reverseAction(value) {


}

function confirmDeleteAction(hrefDelete, rowToDelete) {
    if (!confirm("do you want to delete this?")) {
        return false
    }
    callDeleteAction(hrefDelete, rowToDelete, successDelete);
}
function callDeleteAction(hrefDelete, rowToDelete, callbackSuccess) {
    $.ajax({
        type: "DELETE",
        dataType: "json",
        url: hrefDelete,
        data: {},
        success: function (response) {
            callbackSuccess(response, rowToDelete);
        },
        error: function (response) {

            console.log(response);
        }
    });
}
function successDelete(data, rowToDelete) {

    var action = JSON.parse(data['action_entity']);
    if (action['actionType'] == "ADD") {
        substractAmount(action['amount']);
    }
    if (action['actionType'] == "SUBSTRACT") {

        addAmount(action['amount']);

    }

    $(rowToDelete).fadeToggle();
}
