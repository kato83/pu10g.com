module.exports = env => {
    const path = require('path');
    const isDev = Boolean(env && env.development);
    const mode = isDev ? "development" : "production";
    const outputPath = path.join(__dirname, 'js');

    return {
        mode: mode,
        entry: './src/index.js',
        output: {
            filename: 'bundle.js',
            path: outputPath
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/,
                    query: {
                      babelrc: false,
                      presets: [
                        ['@babel/preset-env', {
                          targets: {
                            ie: '11'
                          },
                          useBuiltIns: 'usage',
                          corejs: 3
                        }],
                      ],
                    }
                },
                {
                    test: /\.css$/,
                    use: [
                        'style-loader',
                        'css-loader',
                        {
                            loader: "postcss-loader",
                            options: {
                                plugins: [
                                    require("autoprefixer")({ grid: true }),
                                    require('cssnano')({ preset: 'default' })
                                ]
                            }
                        }
                    ]
                },
            ]
        },
        resolve: {
            extensions: ['.js']
        },
    }

}
