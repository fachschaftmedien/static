/**
 * created by NasskalteJuni
 */
export default function parentDirPath(path){
  let i = path.lastIndexOf('/');
  return i >= 0 ? path.substring(0, i) : "";
};
