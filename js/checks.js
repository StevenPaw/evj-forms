var age_input;
var underage_form

window.onload = function(){
    age_input = document.getElementById('bday');

    underage_form = document.getElementById("underage");

    age_input.addEventListener('input', function(e) {
        check(this.value);
    });
}

function agecheck(){
    var userinput = document.getElementById('bday').value;
    var dob = new Date(userinput);

    if(userinput==null || userinput=='') {  
        //No Input  
    } else {
        //calculate month difference from current date in time  
        var month_diff = Date.now() - dob.getTime();  
        
        //convert the calculated difference in date format  
        var age_dt = new Date(month_diff);   
        
        //extract year from date      
        var year = age_dt.getUTCFullYear();  
        
        //now calculate the age of the user  
        var age = Math.abs(year - 1970);

        if (age < 18) { 
            underage_form.classList.remove("invisible");
        } else { 
            underage_form.classList.add("invisible");
        }
    }
}