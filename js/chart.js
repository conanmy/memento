/*
 * 数据图表方法
 * @param {object} data 格式如下
 * {
 *     name: '2011',
 *     value: '23'
 * }
 */
memento.chart = {
    template: {
        wrapper: 
            '<div class="chart_wrapper">' +
                '<div class="bar_wrapper">{barContent}</div>' +
                '<div class="name_wrapper">{nameContent}</div>' +
            '</div>',
        barItem: '<div class="bar_item"><span>{num}</span><a style="height:{height}px"></a></div>',
        nameItem: '<div class="bar_item"></div>'
    },
    init: function(data){
        
    }
};
