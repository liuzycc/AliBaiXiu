// 这个是工具模块
define( function () {

    // 该工具模块需要有三个 方法
    function func1() {
        console.log( '工具1' );
    }
    function func2() {
        console.log( '工具2' );
    }
    function func3() {
        console.log( '工具3' );
    }

    // 被称为模块的导出
    return {
        func1: func1, 
        func2: func2,
        func3: func3
    };

} );