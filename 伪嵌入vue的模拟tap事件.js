//      结构和用法如下：（整体思维是，以touchstart事件为触发点，触发tap事件判断，tap()为判断函数，如果判断满足tap条件，才运行放入tap()函数的参数字符串指代的方法;）
//
//   ***在结构html结构中的写法，例：  <div @touchstart="tap(methodName)"></div>    //意思就是：以需要运行的方法名字为参数,调用tap方法。
//
//      在vue实例中的写法，例：
new Vue({
    el: "",
    data: {
        data1: '',
        data2: '',
        data3: ''
    },
    methods: {
        method1: function () {

        },
        method2: function () {

        },
        method3: function () {

        },
        tap: function (methodName) {                  //  即：在methods方法属性里面添加一个tap方法
            let key = true,
                target = event.target,
                oldDate = new Date(),
                oldTouch = event.touches[0],
                oldX = oldTouch.pageX,
                oldY = oldTouch.pageY;
            target.ontouchmove = function (e) {
                let newTouch = e.touches[0],
                    newX = newTouch.pageX,
                    newY = newTouch.pageY;
                if (newX - oldX > 20 || newX - oldX < -20 || newY - oldY > 20 || newY - oldY < -20) {
                    key = false;
                }
            };
            target.ontouchend = function () {
                let newDate = new Date();
                if (newDate - oldDate <= 300 && key) {
                    methodName();                //   满足条件才真正运行methodName函数，实现tap事件
                }
            };
        }
    }

});
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
