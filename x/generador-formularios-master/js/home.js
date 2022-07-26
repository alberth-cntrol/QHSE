ws.addEventListener('open', event => {
    console.log("ws is open")
})
ws.addEventListener('close', event => {
    console.log("ws is closed")
    setTimeout(() => {
        ws = new WebSocket("ws://localhost:6023/")
    }, 1000)
})
ws.addEventListener('message', event => {
    // console.log("ws Message recevied")
    // console.log(event.data)
    data = $.parseJSON(event.data)
        // console.log(data)
    if (data.type == "exec_pos") {
        // console.log(data.response)
        data.response = $.parseJSON(data.response)
        if (data.response.status == "success") {
            exec_pos(data.response)
        }
    } else if (data.type == "manual_sell") {
        data.response = $.parseJSON(data.response)
        if (data.response.status == "success") {
            $('#msg').hide()
            $('#msg').html("<div class='w-100 alert alert-success'><span class='fa fa - check '></span> Coin successfully Sold</div>")
            $('#msg').show("slideDown")

            setTimeout(function() {
                $('#msg').hide("slideUp")
            }, 2500)
            manual_sell(data.response)
        }
    } else if (data.type == "manual_buy") {
        data.response = $.parseJSON(data.response)
        if (data.response.status == "success") {
            manual_buy(data.response)
        }
    } else if (data.type == "new_position") {
        data.response = $.parseJSON(data.response)
        if (data.response.status == "success") {
            new_pos(data.response)
        }
    } else if (data.type == "balance") {
        data.balance = $.parseJSON(data.balance)
        update_balance(data.balance)
    }
})

function update_balance(balance) {

}


// In Position Orders Data
// inPosData = inPosData.replace(/&quot;/g, '\"')
// inPosData = $.parseJSON(inPosData)
var pos = []
var inpos_row_obj = {}
    // i = 0;
    // Object.keys(inPosData).map(k => {
    //     inPosData[k]['bought_price'] = parseFloat(inPosData[k]['bought_price']) / parseInt(inPosData[k]['count'])
    //     pos.push(inPosData[k])
    //     inpos_row_obj[k] = i
    //     i++;

// })

var _rsi_ls = 0
$('#count-position').text(pos.length)
    // inPosition DataTable Initalization
var posTbl = $('#inPosition-tbl').DataTable({
    responsive: true,
    data: pos,
    columns: [{
        data: "time",
        render: (data) => {
            var date = new Date(data)
            var dt = moment(date).format("YYYY-MM-DD HH:mm:ss")
            return dt;
        }
    }, {
        data: "coin",
        render: (data, type, row) => {
            count = (row.count > 1) ? "<span class='badge badge-primary ml-2'>" + row.count + "</span>" : ""
            coin = "<div class='text-center'>" + data.baseAsset + count + "</div>"
            coin += "<div class='text-center'>" + parseFloat(row.qty).toLocaleString('en-US', { style: 'decimal', maximumFractionDigits: 4 }) + "</div>"
                //  coin += "<div class='roe'>" + qty + "</div>"
            return coin
        }
    }, {
        defaultContent: "",
        render: (data, type, row) => {
            pnl = (parseFloat(row.bid_price) * parseFloat(row.qty)) - (parseFloat(row.bought_price) * parseFloat(row.qty))
                //  console.log(pnl)
            roe = (parseFloat(pnl) / (parseFloat(row.bought_price) * parseFloat(row.qty))) * 100
            if (roe >= 0) {
                profit = "<span class='badge badge-success'>" + parseFloat(roe).toFixed(2) + "%</span>"
            } else {
                profit = "<span class='badge badge-danger'>" + parseFloat(roe).toFixed(2) + "%</span>"
            }
            profit = "<div class='profitPerc text-center'>" + profit + "</div>"
            return profit;
        }
    }, {
        data: "bid_price",
        render: (data, type, row) => {
            mark = parseFloat(data).toLocaleString("en-US")
            entry = parseFloat(row.bought_price).toLocaleString("en-US")
            bp = "<div class='bid_price text-right'>" + mark + "</div>"
            bp += "<div class='bought_price text-right'>" + entry + "</div>"
            return bp;
        }
    }, {
        defaultContent: "",
        render: (data, type, row) => {
            currentValue = parseFloat(row.bid_price) * parseFloat(row.qty)
            boughtCost = parseFloat(row.bought_price) * parseFloat(row.qty)
            currentValue = parseFloat(currentValue).toLocaleString('en-US', { style: "decimal", maximumFractionDigits: 8 })
            boughtCost = parseFloat(boughtCost).toLocaleString('en-US', { style: "decimal", maximumFractionDigits: 8 })
            cvbc = "<div class='bid_price text-right'>" + currentValue + "</div>"
            cvbc += "<div class='bought_price text-right'>" + boughtCost + "</div>"
            return cvbc;
        }
    }, {
        defaultContent: "",
        orderable: false,
        render: (data, type, row) => {
            selBtn = "<div class='text-center'><button class='sell-btn btn btn-sm btn-outline-danger text-danger' data-id='" + row.coin.symbol + "' onclick='sell_conf($(this))'>SELL</button></div>"
            return selBtn
        }
    }],
    "createdRow": function(row, data, index) {
        //  console.log(data)
        $(row).attr('data-id', data.coin.symbol);
        $(row).addClass('inPos-items')
    },
    drawCallback: function(settings) {
        $('#count-position').text($('#inPosition-tbl tbody tr.inPos-items').length)

    }
})

function sell_conf(_this) {
    symbol = _this.attr('data-id')
    conf = confirm("Are you sure to sell " + symbol + "?")
    if (conf == true)
        ws.send(JSON.stringify({ type: "manual_sell", symbol: symbol }))
}


// Order History DataTable Initialization
var oHistory = $('#oHistory-tbl').DataTable({
    responsive: true,
    "data": orders,
    "order": [
        [0, 'desc']
    ],
    "columns": [{
        "data": "time",
        render: (data) => {
            var date = new Date(data)
            var dt = moment(date).format("YYYY-MM-DD HH:mm:ss")
            return dt;
        },
        className: "text-center"
    }, {
        "data": "symbol",
        className: "text-center",
        orderable: false
    }, {
        "data": "side",
        "render": (data) => {
            var date = new Date(data)
            var dt = moment(date).format("YYYY-MM-DD HH:mm:ss")
            if (data == "SELL")
                return '<span class="badge badge-danger">SELL</span>';
            else
                return '<span class="badge badge-primary">BUY</span>';
        },
        className: "text-center"
    }, {
        "data": "origQty",
        "render": (data) => {
            return (parseFloat(data).toFixed(4));
        },
        className: "text-right"
    }],
    "createdRow": function(row, data, index) {
        $(row).attr('data-id', data.orderId);
    }
});

// // RSI Data
// RSI_LIST = RSI_LIST.replace(/&#x27;/g, '\"')
// RSI_LIST = $.parseJSON(RSI_LIST)
// var rsiData = [];
// Object.keys(RSI_LIST).map(k => {
//     var date = new Date(RSI_LIST[k]['t']);
//     rsiData.push({
//         x: date,
//         y: parseFloat(RSI_LIST[k].rsi).toFixed(3)
//     })
// })
// rsiData = limit_obj(rsiData, 100)

// // RSI PERIOD
// RSI_PERIOD = parseInt(RSI_PERIOD)

// // kline/Candlestick Data
// kdata = kdata.replace(/&#x27;/g, '\"')
// kdata = $.parseJSON(kdata)
// kdata = limit_obj(kdata, 100)
// Object.keys(kdata).map(k => {
//     kdata[k].x = new Date(kdata[k].x)
// })

// // SMA1 Data
// SMA = SMA.replace(/&#x27;/g, '\"')
// SMA = $.parseJSON(SMA)
// SMA = limit_obj(SMA, 100)
// Object.keys(SMA).map(k => {
//     SMA[k].x = new Date(SMA[k].x)
//     SMA[k].y = parseFloat(SMA[k].y).toFixed(3)
// })

// // SMA1 Data
// SMA2 = SMA2.replace(/&#x27;/g, '\"')
// SMA2 = $.parseJSON(SMA2)
// SMA2 = limit_obj(SMA2, 100)
// Object.keys(SMA2).map(k => {
//     SMA2[k].x = new Date(SMA2[k].x)
//     SMA2[k].y = parseFloat(SMA2[k].y).toFixed(3)
// })

// Apex Chart Candlestick Option
// var options = {
//     series: [{
//         name: 'MA(200)',
//         type: 'line',
//         data: SMA2
//     }, {
//         name: 'MA(50)',
//         type: 'line',
//         data: SMA
//     }, {
//         name: 'Candle',
//         type: 'candlestick',
//         data: kdata
//     }],
//     chart: {
//         id: 'klines',
//         group: 'dispChart',
//         height: 350,
//         type: 'line',
//         foreColor: "#f8f9fa",
//         toolbar: {
//             tools: {
//                 reset: false
//             }
//         }
//     },
//     title: {
//         text: TRADE_SYMBOL + ' 1M Time Interval',
//         align: 'left'
//     },
//     stroke: {
//         width: [2, 2, 1]
//     },
//     tooltip: {
//         shared: true,
//         style: {
//             foreColor: 'black'
//         },
//         theme: "dark",
//         custom: [function({
//             seriesIndex,
//             dataPointIndex,
//             w
//         }) {
//             return parseFloat(w.globals.series[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//         }, function({
//             seriesIndex,
//             dataPointIndex,
//             w
//         }) {
//             return parseFloat(w.globals.series[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//         }, function({
//             seriesIndex,
//             dataPointIndex,
//             w
//         }) {
//             var o = parseFloat(w.globals.seriesCandleO[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//             var h = parseFloat(w.globals.seriesCandleH[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//             var l = parseFloat(w.globals.seriesCandleL[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//             var c = parseFloat(w.globals.seriesCandleC[seriesIndex][dataPointIndex]).toLocaleString('en-US', {
//                 maximumFractionDigits: 3,
//                 minimumFractionDigits: 3
//             })
//             return (
//                 '<div class="p-2">' +
//                 '<div class="text-light">Open: ' + o + '</div>' +
//                 '<div class="text-light">High: ' + h + '</div>' +
//                 '<div class="text-light">Low: ' + l + '</div>' +
//                 '<div class="text-light">Close: ' + c + '</div>' +
//                 '</div>'
//             )
//         }],
//         x: {
//             format: "yyyy-MM-dd h:mm TT"
//         }
//     },
//     xaxis: {
//         type: 'datetime',
//         labels: {
//             datetimeUTC: false
//         }
//     },
//     yaxis: {
//         //     labels: {
//         //         formatter: function(value) {
//         //             return parseFloat(value).toLocaleString('en-US', {
//         //                 style: 'decimal',
//         //                 maximumFractionDigits: 3
//         //             })
//         //         }
//         //     },
//         axisBorder: {
//             show: true,
//             color: '#00000030',
//             offsetX: 0,
//             offsetY: 0
//         },
//         axisTicks: {
//             show: true,
//             borderType: 'solid',
//             color: '#00000030',
//             width: 6,
//             offsetX: 0,
//             offsetY: 0
//         }
//     }
// };

// //  var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
// //  chart1.render();

// // Apex Chart RSI Option
// options = {
//     series: [{
//         name: 'RSI (' + RSI_PERIOD + ')',
//         data: rsiData
//     }],
//     stroke: {
//         width: 1.5,
//     },
//     chart: {
//         id: 'rsi',
//         group: 'dispChart',
//         type: 'line',
//         stacked: false,
//         height: 200,
//         foreColor: "#f8f9fa",
//         zoom: {
//             type: 'x',
//             enabled: true,
//             autoScaleYaxis: true
//         },
//         toolbar: {
//             autoSelected: 'zoom',
//             tools: {
//                 reset: false
//             }
//         }
//     },
//     dataLabels: {
//         enabled: false
//     },
//     markers: {
//         size: 0,
//     },
//     title: {
//         text: 'RSI (' + RSI_PERIOD + ')',
//         align: 'left'
//     },
//     yaxis: {
//         labels: {
//             formatter: function(val) {
//                 return val.toFixed(0);
//             },
//         }
//     },
//     xaxis: {
//         type: 'datetime',
//         labels: {
//             datetimeUTC: false
//         },
//         axisBorder: {
//             show: true,
//             color: '#00000030',
//             offsetX: 0,
//             offsetY: 0
//         },
//         axisTicks: {
//             show: true,
//             borderType: 'solid',
//             color: '#00000030',
//             width: 6,
//             offsetX: 0,
//             offsetY: 0
//         },

//     },
//     grid: {
//         borderColor: '#00000030',
//     },
//     tooltip: {
//         shared: true,
//         y: {
//             formatter: function(val) {
//                 return (val).toFixed(3)
//             }
//         },
//         x: {
//             format: "yyyy-MM-dd h:mm TT"
//         },
//         theme: "dark"
//             // custom: [function(seriesIndex,
//             //     dataPointIndex,
//             //     w) {
//             //     val = w.globals.series[seriesIndex][dataPointIndex]
//             //     return ('<span class="bg-primary badge badge-primary">' + val + '</span>')
//             // }]
//     }
// };

//  var chart2 = new ApexCharts(document.querySelector("#rsi-chart"), options);
//  chart2.render();

// updating chart display function
function update_kline() {
    //  chart1.animations.w.config.chart.animations.enabled = false
    //  chart2.animations.w.config.chart.animations.enabled = false
    //  chart1.update()
    //  chart2.update()
}

// Limit object count (object,limit_count) function
function limit_obj(obj, limit) {
    limit = limit + 1
    var _start = obj.length - limit;
    var new_obj = []
    Object.keys(obj).map(k => {
        if (k >= _start)
            new_obj.push(obj[k])
    })
    return new_obj
}



// Last closed candle data
// lastCdata = kdata[kdata.length - 1]

Object.keys(_sockets).map(k => {
    _sockets[k].addEventListener('open', function(event) {
        console.log(k + ' wss: Connection Open', );
    });

    _sockets[k].addEventListener('close', function(event) {
        console.log(k + ' wss: Connection Closed', );
    });

    _sockets[k].addEventListener('message', function(event) {
        // console.log(k + ' Message from server Received', );
        json = JSON.parse(event.data)
            // received closed candle object
        var candle = json['k']

        // candle value (boolean) if it is closed or not
        var is_candle_closed = candle['x']

        // closed price
        var close = candle['c']

        // Candle time
        var startT = candle['t']
            // Updating mark prices elements
            // $('tbody tr[data-id="' + k + '"] .bid_price').text(parseFloat(close).toLocaleString('en-US', {
            //     style: "decimal",
            //     minimumFractionDigits: 2,
            //     maximumFractionDigits: 5
            // }))
        if ($('tbody tr[data-id="' + k + '"]').length > 0) {
            oData = posTbl.row($('tbody tr[data-id="' + k + '"]')).data()
            oData.bid_price = parseFloat(close)
            posTbl.row($('tbody tr[data-id="' + k + '"]')).data(oData).draw(false)
        }
        // updating in position data
        // $('tbody tr[data-id="' + k + '"] .bid_price').each(function() {
        //     var entry = $(this).closest('tr[data-id="' + k + '"]').find('.bought_price').text()
        //     entry = entry.replace(/,/g, '')
        //     entry = parseFloat(entry)
        //     var mark = parseFloat(close).toFixed(2)
        //     var pnl = parseFloat(mark) - parseFloat(entry)
        //         //  console.log(pnl)
        //         //  $(this).closest('tr').find('.pnl').text(parseFloat(pnl).toLocaleString('en-US', {
        //         //      style: "decimal",
        //         //      minimumFractionDigits: 2,
        //         //      maximumFractionDigits: 2
        //         //  }))
        //     var roe = (parseFloat(pnl) / parseFloat(entry)) * 100
        //     odata
        //     $(this).closest('tr[data-id="' + k + '"]').find('.profitPerc').text(parseFloat(roe).toLocaleString('en-US', {
        //         style: "decimal",
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     }) + '%')
        // })
        if (is_candle_closed) {
            // console.log("candle closed @ " + close)
            // closes.push(close)
            // _rsi_ls = rsiData.length - 1
            // if (closes.length > RSI_PERIOD) {
            // exec_ajax(_rsi_ls)
            // ws.send(JSON.stringify({ symbol: k, type: "exec_pos" }))
            // }
        }

    });

})

function new_pos(response) {
    if (response.position.length > 0) {
        console.log(response.symbol, Object.keys(inpos_row_obj))
        if ($.inArray(response.symbol, Object.keys(inpos_row_obj)) < 0) {
            inpos_row_obj[response.symbol] = posTbl.rows().data().length
            posTbl.row.add(response.position[0]).draw(false);
        } else {
            posTbl.row(inpos_row_obj[response.symbol]).data(response.position[0]).draw(false);
        }
    }
    $('#count-position').text(posTbl.rows().data().length)

    if (response.latest_order_history.length > 0) {
        if ($('#oHistory-tbl tbody').find('tr[data-id="' + response.latest_order_history[0].orderId + '"]').length <= 0) {
            ohl = response.latest_order_history[0]
            oHistory.row.add({ 'orderId': ohl['orderId'], 'time': ohl['time'], 'symbol': ohl['symbol'], 'origQty': ohl['origQty'], 'side': ohl['side'] }).draw(false)
        }
    }
}

function exec_pos(response) {
    // console.log(response)
    if (response.new_order.length > 0) {
        // posTbl.clear().draw(false);
        // inpos_row_obj = {}
        Object.keys(response.new_order).map(k => {
            if ($.inArray(response.new_order[k].coin.symbol, inpos_row_obj) < 0) {
                posTbl.row.add(response.new_order[k]).draw(false);
                inpos_row_obj[response.new_order[k].coin.symbol] = inpos_row_obj.length;
            } else {
                posTbl.row(inpos_row_obj[response.new_order[k].coin.symbol]).data(response.new_order[k]).draw(false);
            }
        })
    } else {
        posTbl.clear().draw(false);
        inpos_row_obj = {}
    }
    if (response.sold_order != null) {

    }
    $('#count-position').text(response.new_order.length)
        // console.log($('#oHistory-tbl tbody').find('tr[data-id="' + response.latest_order_history[0].orderId + '"]').length)
    if (response.latest_order_history.length > 0) {
        if ($('#oHistory-tbl tbody').find('tr[data-id="' + response.latest_order_history[0].orderId + '"]').length <= 0) {
            ohl = response.latest_order_history[0]
            oHistory.row.add({ 'orderId': ohl['orderId'], 'time': ohl['time'], 'symbol': ohl['symbol'], 'origQty': ohl['origQty'], 'side': ohl['side'] }).draw(false)
        }
    }
}

function manual_sell(response) {
    if ($('#inPosition-tbl tr[data-id="' + response.symbol + '"]').length > 0) {
        posTbl.row($('#inPosition-tbl tr[data-id="' + response.symbol + '"]')).remove().draw(false)
        delete inpos_row_obj[response.symbol]
    }
    if (response.latest_order_history.length > 0) {
        if ($('#oHistory-tbl tbody').find('tr[data-id="' + response.latest_order_history[0].orderId + '"]').length <= 0) {
            ohl = response.latest_order_history[0]
            oHistory.row.add({ 'orderId': ohl['orderId'], 'time': ohl['time'], 'symbol': ohl['symbol'], 'origQty': ohl['origQty'], 'side': ohl['side'] }).draw(false)
        }
    }
}

function manual_buy(response) {
    console.log(response)
    Object.keys(response.inpos_orders).map(k => {
        if ($('#inPosition-tbl tr[data-id="' + response.inpos_orders[k].coin.symbol + '"]').length > 0)
            posTbl.row($('#inPosition-tbl tr[data-id="' + response.inpos_orders[k].coin.symbol + '"]')).data(response.inpos_orders[k]);
        else
            posTbl.row.add(response.inpos_orders[k]).draw(false)
    })
    if ($('#oHistory-tbl tbody').find('tr[data-id="' + response.latest_order_history[0].orderId + '"]').length <= 0) {
        ohl = response.latest_order_history[0]
        oHistory.row.add({ 'orderId': ohl['orderId'], 'time': ohl['time'], 'symbol': ohl['symbol'], 'origQty': ohl['origQty'], 'side': ohl['side'] }).draw(false)
    }
}


//calculate rsi from websocket's 
function calc_rsi(cdata, period) {
    var up, down, lastClose, rsi, rs, s;
    up = 0;
    down = 0;
    s = cdata.length - period;
    Object.keys(cdata).map(k => {
        if (k >= s) {
            if (lastClose > 0) {
                var calc = parseFloat(cdata[k]) - parseFloat(lastClose)
                if (calc >= 0) {
                    up = parseFloat(up) + parseFloat(calc)
                } else {
                    down = parseFloat(down) - parseFloat(calc)
                }
            }
            lastClose = cdata[k]
        }
    })
    up = parseFloat(up) / period
    down = parseFloat(down) / period
    rs = parseFloat(up) / parseFloat(down)
    rsi = 100 - (100 / (1 + parseFloat(rs)))
    return parseFloat(rsi).toFixed(3);
}

//calculate SMA from websocket's 
function calc_ma(prices, period) {
    var _s = prices.length - period;
    var _sum = 0;
    Object.keys(prices).map(k => {
        if (k >= _s) {
            _sum += parseFloat(prices[k])
        }
    })
    var ma = parseFloat(_sum) / period;
    return parseFloat(ma).toFixed(3)
}

$(function() {
        load_order_history()
        load_inposition()
    })
    //Order History
window.load_order_history = function() {
    tbl_loader('oHistory-tbl', true)
    $.ajax({
        url: "get_orders/",
        dataType: "json",
        error: err => {
            console.log(err)
            alert("An error occured.")
            tbl_loader('oHistory-tbl', false)
        },
        success: function(resp) {
            if (typeof resp == 'object' && Object.keys(resp).length > 0) {
                Object.keys(resp).map(k => {
                    oHistory.row.add(resp[k]).draw(false)
                })
            } else {
                console.log(resp)
                if (typeof resp != 'object')
                    alert("An error occured.");
                tbl_loader('oHistory-tbl', false)
            }
        },
        complete: function() {
            tbl_loader('oHistory-tbl', false)
        }
    })
}
window.load_inposition = function() {
    // i = 0;
    // Object.keys(inPosData).map(k => {
    //     inPosData[k]['bought_price'] = parseFloat(inPosData[k]['bought_price']) / parseInt(inPosData[k]['count'])
    //     pos.push(inPosData[k])
    //     inpos_row_obj[k] = i
    //     i++;

    // })
    tbl_loader('inPosition-tbl', true)
    $.ajax({
        url: "get_inposition/",
        dataType: "json",
        error: err => {
            console.log(err)
            alert("An error occured.")
            tbl_loader('inPosition-tbl', false)
        },
        success: function(resp) {
            if (typeof resp == 'object' && Object.keys(resp).length > 0) {
                Object.keys(resp).map(k => {
                    posTbl.row.add(resp[k]).draw(false)
                    i = 0;
                    Object.keys(inPosData).map(k => {
                        inPosData[k]['bought_price'] = parseFloat(inPosData[k]['bought_price']) / parseInt(inPosData[k]['count'])
                        posTbl.row.add(resp[k]).draw(false)
                        inpos_row_obj[k] = i
                        i++;

                    })
                })
            } else {
                console.log(resp)
                if (typeof resp != 'object')
                    alert("An error occured.");
                tbl_loader('inPosition-tbl', false)
            }
        },
        complete: function() {
            tbl_loader('inPosition-tbl', false)
        }
    })
}