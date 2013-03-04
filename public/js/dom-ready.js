$(function () {
    $('#go-back-button').click(function () {
        var prevLevel = location.pathname.lastIndexOf('/');
        if (prevLevel === 0)
            return;

        location.href = location.pathname.slice(0, prevLevel);
    });
});
