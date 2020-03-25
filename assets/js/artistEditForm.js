const
    artistSelector = document.getElementById("artist-edit-old"),
    arrayHiddenDiv = Array.from(document.getElementsByClassName("hidden")),
    inputFirstName = document.getElementById("artist-edit-firstname"),
    inputLastName = document.getElementById("artist-edit-lastname"),
    inputBirthDate = document.getElementById("artist-edit-birthdate");

artistSelector.addEventListener("change", () => {
    let
        selectedId = artistSelector.options[artistSelector.selectedIndex].id,
        promisePerson = getDBDataForID(selectedId);

    promisePerson.then(
        /**
         * @param {json} arrayPerson
         * @param {string} arrayPerson.firstname
         * @param {string} arrayPerson.lastname
         * @param {string} arrayPerson.birthdate
         */
        arrayPerson => {
            changeValueOfInputs(arrayPerson.firstname, arrayPerson.lastname, arrayPerson.birthdate);
            showHiddenDivs(arrayHiddenDiv);
        });
});

/**
 * @param firstname {string}
 * @param lastname {string}
 * @param birthdate {string}
 */
function changeValueOfInputs(firstname, lastname, birthdate) {
    inputFirstName.value = firstname;
    inputLastName.value = lastname;
    inputBirthDate.value = birthdate;
}

function showHiddenDivs(arrayDivs) {
    arrayDivs.forEach(hiddenDiv => {
        hiddenDiv.classList.remove("hidden");
    });
}

/**
 * @async
 * @param id
 * @returns {Promise<string>}
 */
async function getDBDataForID(id) {
    let data = await fetch("/admin/artist/get/" + id);
    return await data.json();
}