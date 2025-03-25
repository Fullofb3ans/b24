BX.ready(function () {
    BX.addCustomEvent('onPullEvent-timeman', function (command, params) {
        if (command === 'start_day') {
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

            return false;
        }
    });
});