import { NextApiRequest, NextApiResponse } from 'next'

/**
 * Generates a stylesheet with the specified baseline size and color
 * as a background image on the body element.
 */
export default function(req: NextApiRequest, res: NextApiResponse) {
  const {
    query: { baselineSize, args },
  } = req

  console.log('Generating stylesheet:', `${baselineSize}px ${args}`)

  res.setHeader('Content-Type', 'text/css')
  res.send(`
body {
  position: relative;
}

body:after {
  position: absolute;
  width: auto;
  height: auto;
  z-index: 9999;
  content: '';
  display: block;
  pointer-events: none;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: url(./i/${baselineSize}${
    typeof args === 'string' && args !== '' ? `/${args}` : ''
  });
  background-size: 4px ${baselineSize}px;
}

body:active:after {
  display: none;
}
  `)
}
