<html>
<head>
    <meta charset="UTF-8">
    <title>Test Page</title>
    <style>
        .wrapper {
            width: 400px;
            margin: 50px auto;
            padding: 15px;
            border: 1px dashed #CCC;
            border-radius: 4px;
        }

        /* -----------------------CHECKBOX------------------------------------- */
        /* Сначала обозначаем стили для IE8 и более старых версий
         * т.е. здесь мы немного облагораживаем стандартный чекбокс.
         */
        .checkbox {
            vertical-align: top;
            margin: 0 3px 0 0;
            width: 17px;
            height: 17px;
        }

        /* Это для всех браузеров, кроме совмем старых, которые не поддерживают
        * селекторы с плюсом. Показываем, что label кликабелен.
        */
        .checkbox + label {
            cursor: pointer;
        }

        /* Оформление чекбокса для современных браузеров */

        /* Прячем оригинальный чекбокс . */
        .checkbox:not(checked) {
            position: absolute;
            opacity: 0;
        }

        .checkbox:not(checked) + label {
            position: relative; /* будем позиционировать псевдочекбокс отосительно label */
            padding: 0 0 0 60px; /* оставляем слева от label место под псевдочекбокс */
        }

        /* Оформляем первой части чекбокса в выключенном состоянии (фон). */
        .checkbox:not(checkbox) + label:before {
            content: '';
            position: absolute;
            top: -4px;
            left: 0;
            width: 50px;
            height: 26px;
            border-radius: 13px;
            background: #CDD1DA;
            box-shadow: inset 0 2px 3px rgba(0, 0, 0, .2);
        }

        /* Оформление второй части чекбокс в выключенном состоянии (переключатель) */
        .checkbox:not(checked) + label:after {
            content: '';
            position: absolute;
            top: -2px;
            left: 2px;
            width: 22px;
            height: 22px;
            border-radius: 10px;
            background: #FFF;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .3);
            transition: all .2s; /* Анимация, чтобы чекбокс переключался плавно */
        }

        /* Меняем фон чекбокса, когда он включен */
        .checkbox:checked + label:before {
            background: #9fd468;
        }

        /* Сдвигаем переключатель чекбокса, когда он включен */
        .checkbox:checked + label:after {
            left: 26px;
        }

        /* Показываем получение фокуса */
        .checkbox:focus + label:befor {
            box-shadow: 0 0 0 3px rgba(255, 255, 0, .5);
        }

        /* ------------------------------------------------------------------ */

        /* -----------------------RADIO_------------------------------------- */
        .radio {
            vertical-align: top;
            width: 17px;
            height: 17px;
            margin: 0 3px 0 0;
        }

        .radio + label {
            cursor: pointer;
        }

        .radio:not(checked) {
            position: absolute;
            opacity: 0;
        }

        .radio:not(checked) + label {
            position: relative;
            padding: 0 0 0 35px;
        }

        .radio:not(checked) + label:before {
            content: '';
            position: absolute;
            top: -3px;
            left: 0;
            width: 22px;
            height: 22px;
            border: 1px solid #CDD1DA;
            border-radius: 50%;
            background: #FFF;
        }

        .radio:not(checked) + label:after {
            content: '';
            position: absolute;
            top: 1px;
            left: 4px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #9FD468;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .5);
            opacity: 0;
            transition: all .2s;
        }

        .radio:checked + label:after {
            opacity: 1;
        }

        .radio:focus + label:before {
            box-shadow: 0 0 0 3px rgba(255, 255, 0, .5);
        }
        /* ------------------------------------------------------------------ */


    </style>
</head>
<body>

<div class="wrapper">
    <input type="checkbox" class="checkbox" id="checkbox">
    <label for="checkbox">Статус</label>
</div><!-- .wrapper -->


<div class="wrapper">

    <input type="radio" class="radio" id="radio-1" name="radio"/>
    <label for="radio-1">Радиокнопка переключается кликом по тексту ...</label>

    <br/><br/>

    <input type="radio" class="radio" id="radio-2" name="radio"/>
    <label for="radio-2">... или можно кликнуть на саму радиокнопку</label>

</div><!-- .wrapper -->


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function () {

    });
</script>
</body>
</html>