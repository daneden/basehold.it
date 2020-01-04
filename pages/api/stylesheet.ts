import { NextApiRequest, NextApiResponse } from 'next'

/**
 * Generates a stylesheet with the specified baseline size and color
 * as a background image on the body element.
 */
export default function(req: NextApiRequest, res: NextApiResponse) {
  const {
    query: { size: _size, args: _args },
  } = req

  /**
   * TODO: This is a temporary fix until Now's routing is the same in prod as
   * it is in `now dev`
   */
  const [size, args] = String(_size).includes('?args=')
    ? String(_size).split('?args=')
    : [_size, _args]

  console.log('Generating stylesheet:', `${size}px ${args}`)
  console.log(`Referer: ${req.headers.referer}`)

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
  background: url(./i/${size}${
    typeof args === 'string' && args !== '' ? `/${args}` : ''
  });
  background-size: 4px ${size}px;
}

body:active:after {
  display: none;
}
  `)
}
