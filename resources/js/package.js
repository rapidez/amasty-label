window.amLabelReplaceVariables = (labeltext, product = null) => {
    product ??= window.config?.product

    if (!product) {
        return labeltext
    }

    return labeltext.replaceAll(/(?<replace>{(?<variable>[^\}]*)})/g, (match, replace, input) => {
        switch(input) {
            case 'SPECIAL_PRICE': return window.price(window.productSpecialPrice(product) || window.productPrice(product))
            case 'PRICE': return window.price(window.productPrice(product))
            case 'SAVE_PERCENT': return Math.ceil(100 - ((window.productSpecialPrice(product) || window.productPrice(product)) * 100) / window.productPrice(product)) + '%'
            case 'SAVE_AMOUNT': return window.price((window.productSpecialPrice(product) || window.productPrice(product)) - window.productPrice(product))
            case 'SKU': return product.sku
            case 'STOCK': return product.stock?.qty ?? ''
            default:
                 if (input.startsWith('ATTR:')) {
                    return product[input.substring(5)] ?? ''
                }
                return ''
        }
    })
}