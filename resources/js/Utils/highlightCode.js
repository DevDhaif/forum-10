import lowlight from '../data/highlightLanguages'

function escapeHtml(html) {
  return html.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
}
function toHtml(node) {
  if (node.type === 'text') {
    return node.value
  } else if (node.type === 'element') {
    const className = node.properties.className.join(' ')
    const children = node.children.map(toHtml).join('')
    return `<${node.tagName} class="${className}">${children}</${node.tagName}>`
  } else if (node.type === 'root') {
    return node.children.map(toHtml).join('')
  } else {
    return ''
  }
}

export function highlightCode(body) {
    const codeBlocks = body.match(/<pre><code>([\s\S]*?)<\/code><\/pre>/g)
    if (codeBlocks) {
      codeBlocks.forEach(block => {
        let code = block.replace(/<pre><code>|<\/code><\/pre>/g, '')
        const result = lowlight.highlightAuto(code)
        if (result.language !== 'html') {
          code = escapeHtml(code)
        }
        console.log(code)
        console.log(result)
        const highlighted = toHtml(result)
        console.log(highlighted)
        body = body.replace(block, `<pre><code>${highlighted}</code></pre>`)
      })
    }
    return body
  }
