// pages/_app.js
import App from 'next/app'
import Head from 'next/head'
import React from 'react'

export default class MyApp extends App {
  static async getInitialProps({ Component, ctx }) {
    let pageProps = {}

    if (Component.getInitialProps) {
      pageProps = await Component.getInitialProps(ctx)
    }

    return { pageProps }
  }

  render() {
    const { Component, pageProps } = this.props

    return (
      <>
        <Head>
          <title>
            Basehold.it - quick, painless, JavaScript-free baseline overlays
          </title>
          <meta charSet="UTF-8" />
          <meta
            name="viewport"
            content="initial-scale=1.0,width=device-width"
          />
          <meta
            name="description"
            content="Quick, painless, JavaScript-free baseline overlays"
          />
          <link rel="stylesheet" href="/24" />
          <link rel="stylesheet" href="s.css" />
        </Head>
        <Component {...pageProps} />
      </>
    )
  }
}