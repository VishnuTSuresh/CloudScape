/**
 * @author Vishnu T Suresh
 */
$(document).ready(function() {
    $(".openchestrename").each(function() {
        var form = $(this).find("form").dialog({
            autoOpen: false,
            dialogClass: "form",
            appendTo: "#content",
            title: "Rename",
        }).dialog("close");
        $(this).find("button").click(function() {
            form.dialog("open");
        });
    });
//    var clipboarddiv = $("#clipboard");
//    var clipboardform = $("#clipboardform");
//    function makeclipboard() {
//        clipboarddiv.empty();
//        var count=0;
//        $.each($.jStorage.get("clipboard"), function(index, element) {
//            var name = $("<span></span>").html(element["name"]);
//            var entry = $("<div></div>").append($("<a> x </a>").click(function() {
//                entry.remove();
//                var cbobj = $.jStorage.get("clipboard");
//                delete cbobj[index];
//                $.jStorage.set("clipboard", cbobj);
//            }));
//            entry.append(name);
//            clipboarddiv.append(entry);
//            count++;
//        });
//        
//        if(count===0){
//            clipboardform.hide();
//        }
//        else{
//            clipboardform.show();
//        }
//    }
//    if (!$.jStorage.get("clipboard") || !$.jStorage.get("cookie") || document.cookie != $.jStorage.get("cookie")) {
//        $.jStorage.set("clipboard", {});
//        $.jStorage.set("cookie", document.cookie);
//    }
//    makeclipboard();
//    $.jStorage.listenKeyChange("clipboard", function(key, action) {
//        makeclipboard();
//    });
//    $(".openchestcopy").click(function() {
//        var name = $(this).parent().find("input.openchestname").val();
//        var fullpath = (openchestpath + "/" + name).replace(/\+/g, " ");
//        var cbobj = {
//            "path": openchestpath,
//            "name": name,
//            "action": "copy",
//        };
//        var clipboard = $.jStorage.get("clipboard");
//        clipboard[fullpath] = cbobj;
//        $.jStorage.set("clipboard", clipboard);
//    });
});
