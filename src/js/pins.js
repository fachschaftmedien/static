/**
 * created by NasskalteJuni
 */

import localForage from 'localforage/dist/localforage';

export default class Pins{

  constructor(){
    this._default = [];
    this._key = 'static-pins';
    this._pins = this._load(this._key).then(saved => this._pins = saved || this._default);
    this._pins = this._default;
  }

  isPinned(entry){
    return this._indexOf(entry) >= 0;
  }

  pin(entry){
    let index = this._indexOf(entry);
    if(index === -1){
      this._pins.push(entry);
    }
    return this._save();
  }

  all(sync = true){
    return sync ? this._pins : this._load();
  }

  unpin(entry){
    let index = this._indexOf(entry);
    if(index >= 0){
      this._pins.splice(index, 1);
    }
    return this._save();
  }

  _indexOf(pin){
    return this._pins.findIndex(el => el.path === pin.path);
  }

  _load(){
    return localForage.getItem(this._key) || [];
  }

  _save(){
    return localForage.setItem(this._key, this._pins);
  }
}

