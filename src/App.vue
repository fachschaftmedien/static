<template>
  <div id="app">
    <aside :class="'side-search '+(navActive ? 'active' : 'inactive')" @mouseenter="navActive = true" @mouseleave="navActive = false">
      <div class="aside-peek">
        <span :class="'fa side-menu-icon centered '+(navActive ? 'fa-arrow-left' : 'fa-bars')"></span>
      </div>
      <div class="aside-content container">
        <header class="aside-headline centered">Suche & weiteres</header>
        <search :tree="tree" @searched="searchFor"></search>
        <pinned :pins="pinned" @unpin="unpin" @selected="goLevelTo"></pinned>
        <selection-history :history="history" @selected="goLevelTo"></selection-history>
        <login @auth="auth"></login>
      </div>
    </aside>
    <main class="main-content container">
      <header class="breadcrumb-header">
        <breadcrumbs :current="current" @levelTo="goLevelTo"></breadcrumbs>
      </header>
      <section class="directory-container">
        <directory-view :loggedIn="credential && credential.length > 0" :current="current" :tree="tree" :pins="pinned" @fileOpen="openFile" @dirOpen="openDir" @levelUp="goLevelUp" @pin="pin" @unpin="unpin"></directory-view>
      </section>
    </main>
  </div>
</template>

<script>
import Search from '@/components/Search'
import DirectoryView from '@/components/DirectoryView'
import Breadcrumbs from '@/components/Breadcrumbs'
import SelectionHistory from '@/components/SelectionHistory'
import Pinned from '@/components/Pinned'
import Login from '@/components/Login'
import parentDirPath from './js/parentDirPath'
import History from './js/history'
import Pins from './js/pins'

const history = new History();
const pins = new Pins();
const fallback =  require('../test.json');
const load = () => {return {name: "", path: "", type: "dir", children: [] }};


export default {
  name: 'app',
  components: {
    SelectionHistory,
    Search,
    Breadcrumbs,
    Pinned,
    DirectoryView,
    Login
  },
  data(){
    return {
      tree: load(),
      current: load(),
      history: history,
      navActive: false,
      pinned: [],
      credential: null
    }
  },
  created(){
    this.pinned = pins.all();
    const headers = new Headers();
    headers.append('Authorization', 'Basic ' + btoa("studident:kukident"));
    fetch('http://static.fachschaftmedien.de/folder.php', {headers: headers})
      .then(res => res.json())
      .then(out => {
        console.log('success', out);
        this.tree = out;
        this.current = out;
      })
      .catch(err => {
        this.tree = fallback;
        this.current = fallback;
        console.warn('using test-json as development fallback');
        console.error('failed fetching data', err.message);
      });
  },
  methods: {
    activateAside(bool=true){
        this.navActive = bool;
    },
    find(func, elements=this.tree.children, i=0, arr=[]){
        elements.forEach(el => {
          if(!el) return;
          if(func(el, i, elements, arr)){
            arr.push(el);
          }
          if(el.children){
              arr.push.apply(this.find(func, el.children, i+1, arr));
          }
        });
        return arr;
    },
    openFile(entry){
        this.history.add(entry);
        window.open(entry.path);
    },
    openDir(entry){
        this.history.add(entry);
        this.current = entry;
    },
    goLevelUp(entry){
      this.history.add(entry);
      let parentPath = parentDirPath(entry.path);
      this.current = parentPath.length > 0 ?  this.find(el => el.path && el.path === parentPath)[0] : this.tree;
    },
    goLevelTo(entry){
      this.history.add(entry);
      let path = entry.path;
      this.current = path.length > 0  && path !== '/' ?  this.find(el => el.path && el.path === path)[0] : this.tree;
      if(entry.type === 'file'){
        window.open(path);
      }
    },
    searchFor(letters){
      letters = letters.toLowerCase();
      this.current = letters.length === 0 ? this.tree : {
        path: "",
        name: "",
        type: "dir",
        children: this.find(el => el.name && el.name.toLowerCase().indexOf(letters) >= 0)
      }
    },
    pin(entry){
      pins.pin(entry).then(changed => {
          this.pinned = changed
      }).catch(console.warn);
    },
    unpin(entry){
      pins.unpin(entry).then(changed => {
          this.pinned = changed
      }).catch(console.warn);
    },
    auth(secret){
        this.credential = btoa(secret);
    }
  }
}
</script>

<style>

</style>
