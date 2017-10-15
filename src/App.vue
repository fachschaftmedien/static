<template>
  <div id="app">
    <aside :class="'side-search '+(navActive ? 'active' : 'inactive')" @mouseenter="navActive = true" @mouseleave="navActive = false">
      <div class="aside-peek">
        <span :class="'fa side-menu-icon centered '+(navActive ? 'fa-arrow-left' : 'fa-bars')"></span>
      </div>
      <div class="aside-content">
        <header class="aside-headline centered">Suche & weiteres</header>
        <search :tree="tree" @searched="searchFor"></search>
        <selection-history :history="history" @selected="goLevelTo"></selection-history>
      </div>
    </aside>
    <main class="main-content container">
      <header class="breadcrumb-header">
        <breadcrumbs :current="current" @levelTo="goLevelTo"></breadcrumbs>
      </header>
      <section class="directory-container">
        <directory-view :current="current" :tree="tree" @fileOpen="openFile" @dirOpen="openDir" @levelUp="goLevelUp"></directory-view>
      </section>
    </main>
  </div>
</template>

<script>
import Search from '@/components/Search.vue'
import DirectoryView from '@/components/DirectoryView.vue'
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import SelectionHistory from '@/components/SelectionHistory.vue'
import parentDirPath from './js/parentDirPath'
import History from './js/history'

const history = new History();
const fallback =  require('../test.json');
const load = () => {return {name: "", path: "", type: "dir", children: [] }};


export default {
  name: 'app',
  components: {
    SelectionHistory,
    Search,
    Breadcrumbs,
    DirectoryView
  },
  data(){
    return {
      tree: load(),
      current: load(),
      history: history,
      navActive: false
    }
  },
  created(){
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
        console.error('failed fetching data');
      });
  },
  methods: {
    activateAside(bool=true){
        console.log('activateAside', bool);
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
    },
    searchFor(letters){
      letters = letters.toLowerCase();
      this.current = letters.length === 0 ? this.tree : {
        path: "",
        name: "",
        type: "dir",
        children: this.find(el => el.name && el.name.toLowerCase().indexOf(letters) >= 0)
      }
    }
  }
}
</script>

<style>

</style>
