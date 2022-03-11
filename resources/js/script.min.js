/**
 * Simulate week
 * @param week
 * @param elementSelf
 */
function simulateWeek(week, elementSelf) {
    const actionUrl = $(elementSelf).data('action-url');
    const lastWeek = $('#lastWeek').val();

    if (week == lastWeek){
        $('#play-action-buttons').hide();
    }

    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response.length) {
                $(`#week-${week}`).html(response);
                refreshStandings();
                refreshPredictions();
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}

/**
 * Simulate next week
 */
function simulateNextWeek()
{
    const nextWeek = $('#nextWeek');
    simulateWeek(nextWeek.val(), nextWeek);
}

/**
 * Simulate all weeks at once
 * @param elementSelf
 */
function simulateAll(elementSelf) {
    const actionUrl = $(elementSelf).data('action-url');
    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response.length) {
                $('#all-weeks').html(response);
                refreshStandings();
                refreshPredictions();
                $('#play-action-buttons').hide();
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}

/**
 * Refresh standings table
 */
function refreshStandings() {
    const standingTable = $('#standings-table');
    const actionUrl = standingTable.data('update-url')
    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response.length) {
                standingTable.html(response);
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}

/**
 * Reset all statistics and matches
 * @param elementSelf
 */
function resetAll(elementSelf)
{
    const actionUrl = $(elementSelf).data('action-url');
    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response){
                refreshStandings();
                refreshMatches();
                refreshPredictions();
                $('#play-action-buttons').show();
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}

/**
 * Refresh matches
 */
function refreshMatches()
{
    const matchTables = $('#all-weeks');
    const actionUrl = matchTables.data('refresh-url')
    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response.length) {
                matchTables.html(response);
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}

/**
 * Refresh predictions
 */
function refreshPredictions()
{
    const predictionsTable = $('#predictions-table');
    const actionUrl = predictionsTable.data('action-url')
    $.ajax({
        url: actionUrl,
        type: "POST",
        data: {"_token": CSRF_TOKEN},
        success: function (response) {
            if (response.length) {
                predictionsTable.html(response);
            }
        },
        error: function (err) {
            alert("Something went wrong");
        }
    });
}
