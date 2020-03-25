const
    movieSelector = document.getElementById("movie-title-old"),
    arrayHiddenDiv = Array.from(document.getElementsByClassName("hidden")),

    inputTitle = document.getElementById("movie-title-new"),
    inputGenre = document.getElementById("movie-genre-new"),
    inputDirector = document.getElementById("movie-director-new"),
    inputYear = document.getElementById("movie-year-new"),
    inputPoster = document.getElementById("movie-poster-preview"),
    inputSynopsis = document.getElementById("movie-synopsis-new");

movieSelector.addEventListener("change", () => {
    let
        movieSelected = movieSelector.options[movieSelector.selectedIndex].value,
        promiseMovie = getDBDataForMovie(movieSelected);


    promiseMovie.then(
        /**
         * @param {json} arrayMovie
         * @param {string} arrayMovie.title
         * @param {number} arrayMovie.genre
         * @param {number} arrayMovie.director
         * @param {number} arrayMovie.year
         * @param {string} arrayMovie.poster
         * @param {string} arrayMovie.synopsis
         */
        arrayMovie => {
            changeValueOfMovieInputs(
                arrayMovie.title, arrayMovie.genre,
                arrayMovie.director, arrayMovie.year,
                arrayMovie.poster, arrayMovie.synopsis
            );
            showHiddenDivs(arrayHiddenDiv);

        }
    )
});

/**
 * @param title {string}
 * @param genre {number}
 * @param director {number}
 * @param year {number}
 * @param poster {string}
 * @param synopsis {string}
 */
function changeValueOfMovieInputs(
    title, genre,
    director, year,
    poster, synopsis
) {

    inputTitle.value = title;
    inputYear.value = year;
    inputPoster.src = "/Uploads/posters/" + poster;
    inputSynopsis.value = synopsis;

    inputGenre.value = genre;
    inputDirector.value = director;
}

/**
 * @async
 * @param id
 * @returns {Promise<string>}
 */
async function getDBDataForMovie(id) {
    let data = await fetch("/admin/movie/get/" + id);
    return await data.json();
}

function showHiddenDivs(arrayDivs) {
    arrayDivs.forEach(hiddenDiv => {
        hiddenDiv.classList.remove("hidden");
    });
}


$(".custom-file-input").on("change", function () {
    const fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
