window.nextId = function nextId(prefix){
    window.autoId++;
    return `${prefix}_${window.autoId}`;
};
