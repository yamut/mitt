module.exports = {
    env: {
        browser: true,
        es2021: true,
        node: true,
        jquery: true
    },
    extends: 'standard',
    overrides: [
        {
            env: {
                node: true
            },
            files: [
                '.eslintrc.{js,cjs}',
                'resources/js/app.js'
            ],
            parserOptions: {
                sourceType: 'module'
            }
        }
    ],
    parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module'
    },
    rules: {}
}
