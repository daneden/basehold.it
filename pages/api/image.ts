import { NextApiRequest, NextApiResponse } from 'next'

const createSVG = (options, res: NextApiResponse) => {
  const WIDTH = 4
  const { color = 'rgba(0,0,0,.8)', height } = options
  const svg = `
    <svg
      viewbox="0 0 ${WIDTH} ${height}"
      xmlns="http://www.w3.org/2000/svg">
      <line
        x1="0"
        x2="${WIDTH}"
        y1="${height}"
        y2="${height}"
        stroke="${color}"
      />
    </svg>
  `

  res.setHeader('Content-Type', 'image/svg+xml')
  res.send(svg)
}

// This function takes the arguments passed to the URL and turns them into an
// rgb(a) string
const argsToRgba = (args?: string[]) => {
  if (args === undefined) return args

  let color = undefined

  if (args.length === 1) {
    // If just one argument was sent, it's probably a HEX code
    const components = /^([a-f\d]{1,2})([a-f\d]{1,2})([a-f\d]{1,2})$/i
      .exec(args[0])
      .slice(1)
      .map(component => parseInt(component, 16))
    color = `rgb(${components[0]}, ${components[1]}, ${components[2]})`
  } else if (args.length >= 3) {
    // Otherwise, if 3 or 4 args were sent, it's an rgb(a) value
    const [r, g, b, a = 0.8] = args
    color = `rgba(${r}, ${g}, ${b}, ${a})`
  }

  return color
}

/**
 * Generates and returns an SVG for the specified baseline size and color
 */
export default function(req: NextApiRequest, res: NextApiResponse) {
  const {
    query: { size, args },
  } = req

  const color = argsToRgba(
    typeof args == 'string' && args !== '' ? args.split('/') : undefined
  )

  console.log('Generating image:', `${size}px ${args}`)
  console.log(`Referer: ${req.headers.referer}`)

  return createSVG({ height: size, color }, res)
}
