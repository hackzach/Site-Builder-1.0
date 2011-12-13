function title(msg) {
 msg = msg.substring(1, msg.length) + msg.substring(0, 1);
 document.title = msg;
 setTimeout("title(msg)", 100);
 }
