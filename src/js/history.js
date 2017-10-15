/**
 * created by NasskalteJuni
 */
export default class History{

  constructor(length=10, source=[]){
    this.source = source;
    this.length = length;
  }

  add(entry){
    if(this.indexOf(entry) >= 0) this.remove(entry);
    this.source.unshift(entry);
    if(this.source.length > this.length) this.source.pop();
  }

  indexOf(entry){
    return this.source.findIndex(el => el.path === entry.path);
  }

  remove(entry){
    let i = typeof entry === 'number' ? entry : this.indexOf(entry);
    if(i >= 0) this.source.splice(i, 1);
  }

  entries(){
    return this.source;
  }
}

