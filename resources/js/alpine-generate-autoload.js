const path = require("path");
const fs = require("fs");

let files = {};
function throughDirectory(directory) {
    fs.readdirSync(directory).forEach(file => {
        const absolute = path.join(directory, file);
        if (fs.statSync(absolute).isDirectory()) return throughDirectory(absolute);

        const componentName = file.split('.')[0];
        const extension = file.split('.')[1];

        if(absolute.endsWith('components/' + file) && extension == 'js') files[componentName] = '../../' + absolute
    });
}

throughDirectory("./app/Containers");
throughDirectory("./resources/views");

const autoload_path = './resources/js/alpine-data-autoload.js';

fs.writeFile(autoload_path, '', () => {
    fs.appendFile(autoload_path, `import Alpine from "alpinejs";`, () => {
        for (const [componentName, path] of Object.entries(files)) {
            let str = `import ${componentName} from '${path}'; Alpine.data('${componentName}Data', ${componentName});`;
            fs.appendFile(autoload_path, str, () => {});
        }
    });
})


