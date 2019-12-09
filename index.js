const path = require("path")
const express = require("express")
const app = express()

const PORT = process.env.port | 8000

const createSVG = (options, res) => {
  const WIDTH = 4
  const { color = "rgba(0,0,0,.8)", height } = options
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

  res.type("image/svg+xml")
  res.send(svg)
}

// This function takes the arguments passed to the URL and turns them into an
// rgb(a) string
const argsToRgba = args => {
  if (args === undefined) return args

  let color = undefined

  if (args.length === 1) {
    // If just one argument was sent, it's probably a HEX code
    const components = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i
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

// Serve home page and assets
app.use(express.static(__dirname))
app.get("/", (req, res) => {
  res.sendFile(path.resolve(__dirname, "home.html"))
})

// Requests for images
app.get(/^\/i\/([0-9]{1,3})(\/(.*))?/, (req, res) => {
  const { "0": height, "2": args } = req.params
  const colorArgs = args !== undefined ? args.split("/") : undefined

  const options = {
    color: argsToRgba(colorArgs),
    height: Number(height),
  }

  return createSVG(options, res)
})

// Requests for stylesheets
app.get(/^\/(b\/)?([0-9]{1,3})(\/(.*))?/, (req, res) => {
  const { "1": height, "3": args } = req.params
  res.type("text/css")
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
  background: url(/i/${height}${args !== undefined ? "/" + args : ""});
  background-size: 4px ${height}px;
}

body:active:after {
	display: none;
}
  `)
})

// Start the app
app.listen(PORT)
console.log(`Process started on port ${PORT}`)
