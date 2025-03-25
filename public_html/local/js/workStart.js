console.log('workStart.js loaded');

BX.ready(function () {
    console.log('BX.ready executed');

    // Try direct binding to the timeman button
    BX.bind(document, 'click', function (e) {
        if (e.target.matches('[data-role="start-timer-btn"]')) {
            console.log('Timer button clicked');

            var popup = new BX.PopupWindow("workday-popup", null, {
                content: `
                    <div style="padding: 20px;">
                        <p>Вы уверены, что хотите начать рабочий день?</p>
                        <button id="confirm-workday" class="ui-btn ui-btn-primary">
                            Подтвердить начало дня
                        </button>
                    </div>
                `,
                closeIcon: true,
                closeByEsc: true,
                overlay: true
            });

            popup.show();

            BX.bind(BX('confirm-workday'), 'click', function () {
                BX.timeman.chronometer.start();
                popup.close();
            });

            e.preventDefault();
            return false;
        }
    });
});
