// 是一个查询的模块
define( [ 'init' ], function () {
    // 这是一个查询模块
    // 什么时候执行呢?
    // 我们在处理页面的时候, 必须保证 init 模块先执行, query 模块后执行

    // 在 define 中依赖 init 模块就表示 一定是 init 先执行
    console.log( '这是一个 query 模块' );

} );