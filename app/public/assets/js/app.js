$(".form-field-icon-edit").on("click", function(){
    const articleField = $(this).parent();
    const articleId = articleField.data("article-id");
    const baseURL = window.location.origin;
    const requestURL = baseURL + "/article/article?articleId=" + articleId;
    let articleToEdit;

    $.ajax({
        method: "GET",
        url: requestURL,
    }).done(function(response){
        articleToEdit = JSON.parse(response);

        $("#cancel-edit-icon").removeAttr("hidden");
        $("#create-edit-form").attr("action", "/article/edit");
        $("#create-section-title").text("Edit News");
        $("#create-submit-button").attr("value", "Save");
        $("#create-title-field").attr("value", articleToEdit.title)
        $("#create-description-field").text(articleToEdit.description);
        $("#article-edit-id").attr("value", articleToEdit.id);
    })
});

$("#cancel-edit-icon").on("click", function(){
    $("#cancel-edit-icon").attr("hidden", "hidden");
    $("#create-edit-form").attr("action", "/article/create");
    $("#create-section-title").text("Create News");
    $("#create-submit-button").attr("value", "Create");
    $("#create-title-field").attr("value", "")
    $("#create-description-field").text("");
    $("#article-edit-id").attr("value", "");
});

$(".form-field-icon-delete").on("click", function (){
    const articleField = $(this).parent();
    const articleId = articleField.data("article-id");
    const baseURL = window.location.origin;
    const deleteForm = $("#delete-article");
    deleteForm.children("input").attr('value', articleId);
    deleteForm.trigger("submit");
});