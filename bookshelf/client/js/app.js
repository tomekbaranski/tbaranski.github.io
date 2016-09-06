$(function(){
    var newBookFrom = $("#createForm");
    var loadingDiv = $("#loading");
    var booksDiv = $("#books");
    var nameInput = $("#nameInput");
    var descriptionInput = $("#descriptionInput");
    var authorInput = $("#authorInput");

    var showBooks = function () {
        loadingDiv.hide();
        booksDiv.show();
    };

    newBookFrom.on('submit', function(event){
        var nameValue = nameInput.val();
        var descriptionValue = descriptionInput.val();
        var authorValue = authorInput.val();

        if(!nameValue || !descriptionValue || !authorValue){
            alert("Fill in all fields!");
        }else {
            booksDiv.hide();
            loadingDiv.show();
            setTimeout(showBooks, 2200);

            $.ajax({
                    url: "http://localhost:8888/406_warsztat3/bookshelf/api/books.php",
                    method: "POST",
                    data: "name=" + nameValue + "&description=" + descriptionValue + "&author=" + authorValue
                })
                .done(function(data){
                    bookShelf();
                    console.log('dodano ksiazke');
                })
        }
    });

    var bookShelf = function () {
        $.ajax({
                url: "http://localhost:8888/406_warsztat3/bookshelf/api/books.php",
                method: "GET",
                dataType: "JSON"
            })
            .done(function(booksTable){
                console.log('Done books table');

                var loadBooks = function () {
                    booksDiv.empty();
                    for(var i = 0; i < booksTable.length; i++){
                        var newDiv = $('<div class="row">');
                        newDiv.attr("data-id", booksTable[i].id);
                        newDiv.append('<div class="col-lg-2"></div>');
                        newDiv.append('<div class="col-lg-5 book-title">'+booksTable[i].name + ' - ' + booksTable[i].author + '</div>');
                        newDiv.append($("<button class='btn btn-primary btn-show delButton'>Delete</button>"));
                        newDiv.append($("<button class='btn btn-primary btn-show showButton'>Show</button></div>"));
                        newDiv.append("<div class='showMore'></div>");
                        newDiv.find(".showMore").append('<div class="row"></div>');
                        newDiv.find(".showMore").append('<div class="row"><div class="col-lg-2 book-author">Description:</div><div class = "col-lg-8 book-description">'
                            +booksTable[i].description+'</div></div>');
                        newDiv.find(".showMore").append('<div class="row"><div class="col-lg-2 book-author">Autor:</div><div class = "col-lg-7 book-description">'
                            +booksTable[i].author+'</div></div>');
                        newDiv.find(".showMore").hide();
                        newDiv.appendTo(booksDiv);
                    };
                    console.log('zaladowano ksiazki');
                };
                loadBooks();

                var showButton = $(".showButton");

                showButton.on('click', function (event) {
                    console.log('clik');
                    if($(this).parent().find(".showMore").is(":visible")){
                        $(this).parent().find(".showMore").hide();
                        $(this).parent().find(".showButton").text("Show")
                    }else {
                        $(this).parent().find(".showMore").show();
                        $(this).parent().find(".showButton").text("Hide")
                    }
                });

                var delButton = $(".delButton");
                delButton.on('click', function (event) {
                    booksDiv.hide();
                    booksDiv.empty();
                    loadingDiv.show();
                    setTimeout(showBooks, 1500);
                    var bookId = $(this).parent().data('id');
                    $.ajax({
                            url: "http://localhost:8888/406_warsztat3/bookshelf/api/books.php",
                            data: {
                                deleteid: bookId
                            },
                            method: "DELETE"
                        })
                        .done(function (deleteBook) {
                            bookShelf();
                            console.log('pozycja usunieta')
                        })
                        .fail(function(xhr, status, errorThrown){
                            console.log(status);
                            console.log(errorThrown);
                        });
                })

            })
            .fail(function(xhr, status, errorThrown){
                console.log(status);
                console.log(errorThrown);
            });
    };
    booksDiv.hide();
    loadingDiv.show();
    setTimeout(showBooks, 1000);
    bookShelf();
});