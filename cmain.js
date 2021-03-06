var xmlHttp = new XMLHttpRequest();
var showArchived = false;


// Assign callback for when we are ready
xmlHttp.onreadystatechange = function() {
  // 200 is STATUS OKAY
  if (this.readyState == 4 && this.status == 200)
    {
      if (!this.responseText)
      {
        HogLog.w("Server responded without conent to order request.");
      }
      else
      {
        HogLog.d("Server responed to order request with: " + this.responseText);
        var stuffs = JSON.parse(this.responseText);
        fillOrders(stuffs.orders);
      }
      
      
    }
}

// jarray INPUT FOR ORDERS
function fillOrders(orders)
{
  orders.forEach( function(order) {
    addOrder(order);
  })
}

var i = 0;
function addOrder(order)
{
  // show or not show archived
  if (showArchived == false && (order.oStatus == "ARCHIVED" || order.oStatus == "Archived"))
    return;
  
  var temp = document.getElementById("order-template");
  
  var clone = temp.content.cloneNode(true);
  

  var id = "Order " + i;
  
  clone.id = id;
  
  document.getElementById("orders").appendChild(clone);
  
  
  // F javascript
  var pickups = document.getElementsByClassName("pickup");
  
    var dests = document.getElementsByClassName("destination");
    var pickupTimes = document.getElementsByClassName("pickupTime");
      var status = document.getElementsByClassName("Status");
   var statusbars = document.getElementsByClassName("statusBar");
  var links = document.getElementsByClassName("orderLink");

  let pickupDate = new Date(parseInt(order.pickupDate)*1000);

  
  pickups[i].innerHTML += order.pickup;
  dests[i].innerHTML +=  order.destination;
  pickupTimes[i].innerHTML += pickupDate.toLocaleString();
  status[i].innerHTML += order.oStatus;
  statusbars[i].value = parseInt(order.statusPercent);
  links[i].href = "order.php?order=" + order.orderID;
  i++;
   
}



document.addEventListener("DOMContentLoaded", function(){
    // Make our http request
    xmlHttp.open("GET", "corderdata.php", true);
    HogLog.d("SENDING GET to corderdata.php with null content.");
    xmlHttp.send();

});