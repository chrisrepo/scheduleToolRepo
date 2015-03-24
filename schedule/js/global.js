/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    var classes = new Bloodhound({
        datumTokenizer: function(data) {
        // **search in other property values; e.g. data.title & data.desc etc..**
        var x = Bloodhound.tokenizers.obj.whitespace('courseCode');
        var y = Bloodhound.tokenizers.obj.whitespace('courseTitle');
        return x.concat(y);
    },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit: 8,
        remote: 'php/classes.php?query=%QUERY'
    });
    
    classes.initialize();
    $('#myClasses').typeahead({
        highlight: true,
        hint: true,
        minlength: 2
    }, {
        name: 'courseCode',
        displayKey: function(classes){
          return classes.courseCode + " - " + classes.courseTitle;  
        },
        source: classes.ttAdapter()
    });
    
  });
  
