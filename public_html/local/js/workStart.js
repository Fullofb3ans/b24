console.log('workStart.js loaded');

BX.ready(function () {
    console.log('BX.ready executed');

    document.addEventListener('click', function (e) {
        const timemanButton = e.target.closest('.timeman-wrap');

        const startButton = document.querySelector('.timeman-start-button');


        if (timemanButton) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

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
                popup.close();
                startButton.click();
            });

            return false;
        }
    }, true);  // Using capture phase
});
