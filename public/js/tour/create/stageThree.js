function checkDiscount(_index, _value, _kind){
    var errorIndex = false;

    if(_kind == 1)
        disCountTo[_index] = parseInt(_value);
    else
        disCountFrom[_index] = parseInt(_value) ;


    for(i = 0; i < disCountTo.length && i < disCountFrom.length; i++){
        if(i != _index){
            if(disCountTo[i] != 0 && disCountTo[i] != -1 && disCountFrom[i] != 0 && disCountFrom[i] != -1 ){
                if((_value >= disCountFrom[i] && _value <= disCountTo[i] )){
                    errorIndex = true;
                    break;
                }
            }
        }
    }

    if(errorIndex){
        if(_kind == 1)
            document.getElementById('disCountTo_' + _index).classList.add('errorClass');
        else
            document.getElementById('disCountFrom_' + _index).classList.add('errorClass');

    }
    else{
        if(_kind == 1)
            document.getElementById('disCountTo_' + _index).classList.remove('errorClass');
        else
            document.getElementById('disCountFrom_' + _index).classList.remove('errorClass');

    }
}
function checkAllDiscount(){
    discountError = false;

    for(i = 0; i < disCountTo.length && i < disCountFrom.length; i++){
        if (disCountTo[i] != -1 && disCountFrom[i] != -1) {
            if (disCountFrom[i] == 0 || disCountTo[i] == 0) {
                if (disCountTo[i] == 0)
                    document.getElementById('disCountTo_' + i).classList.add('errorClass');
                if (disCountFrom[i] == 0)
                    document.getElementById('disCountFrom_' + i).classList.add('errorClass');
            }
            else if (disCountFrom[i] > disCountTo[i]) {
                document.getElementById('disCountTo_' + i).classList.add('errorClass');
                document.getElementById('disCountFrom_' + i).classList.add('errorClass');
            }
            else {
                var checkErrorTo = false;
                var checkErrorFrom = false;

                for (j = i + 1; j < disCountTo.length && j < disCountFrom.length; j++) {
                    if (disCountTo[j] != 0 && disCountTo[j] != -1 && disCountFrom[j] != 0 && disCountFrom[j] != -1) {
                        if (!checkErrorFrom && disCountFrom[i] >= disCountFrom[j] && disCountFrom[i] <= disCountTo[j]) {
                            document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                            checkErrorFrom = true;
                            discountError = true;
                        }
                        if (!checkErrorTo && disCountTo[i] >= disCountFrom[j] && disCountTo[i] <= disCountTo[j]) {
                            document.getElementById('disCountTo_' + i).classList.add('errorClass');
                            checkErrorTo = true;
                            discountError = true;
                        }
                    }
                }

                if(!checkErrorFrom){
                    document.getElementById('disCountFrom_' + i).classList.remove('errorClass');
                }
                if(!checkErrorTo){
                    document.getElementById('disCountTo_' + i).classList.remove('errorClass');
                }
            }
        }
    }

}

$('#minCost').keyup(e => document.getElementById('minCostDiv').classList.remove('errorClass'));
$('#minCapacity').keyup(e => document.getElementById('minCapacityDiv').classList.remove('errorClass'));
$('#maxCapacity').keyup(e => document.getElementById('maxCapacityDiv').classList.remove('errorClass'));
