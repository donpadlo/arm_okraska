/**
 * Добавить реакцию на событие изменение размера окна - меням размер грида
 * по размерам таблицы контента
 * @param {type} selector
 * @return {undefined}
 */
function BindResizeble(selector,contentselector){
    $(window).bind('resize', function() {
        $(selector).setGridWidth($(contentselector).width());
    }).trigger('resize');  
}
// использование Math.round() даст неравномерное распределение!
function getRandomInt(min, max){
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
