/*function app() {
	const buttons = document.querySelectorAll('.btn')

	const cards = document.querySelectorAll('.region')

	function filter (category, items) {
		items.forEach((item) => {
			const isItemFiltered = !item.classList.contains(category)
			if (isItemFiltered) {
				item.classList.add('close')
			}
		})
	}

	buttons.forEach((button) => {
		button.addEventListener('click', () => {
			// console.log(button.dataset.filter)
			const currentCategory = button.dataset.filter
			filter(currentCategory, cards)
			console.log()
		})
	})
}

//app()




/*var servResponse = document.querySelector('#response');

//var servResponse2 = document.querySelector('#okno');

document.forms.ourForm.onsubmit = function(e){
	e.preventDefault();

	var userInput = document.forms.ourForm.ourForm_inp.value;
	userInput = encodeURIComponent(userInput);

	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'ajax.php');

	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
	

	xhr.onreadystatechange = function()
    {
        //Если обмен данными завершен
        if (xhr.readyState == 4)
        {
			//console.log(servResponse.textContent)
            //Передаем управление обработчику пользователя
			//servResponse.textContent = xhr.responseText;
			servResponse.textContent = xhr.responseText;
        }
    }


	xhr.send('ourForm_inp=' + userInput);

}*/
function tableSearch() {
    var phrase = document.getElementById('search-text');
    var table = document.getElementById('info-table');
    var regPhrase = new RegExp(phrase.value, 'i');
    var flag = false;
    for (var i = 1; i < table.rows.length; i++) {
        flag = false;
        for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag) {
            table.rows[i].style.display = "";
        } else {
            table.rows[i].style.display = "none";
        }

    }
}