export interface IWithSelect {
  setSelect: (e: string) => void;
}

export interface IBrandSelect {
  loadingSelect: boolean;
  getInfo: (type?: "left" | "right") => void;
  setSelectInfo: (e: string) => void;
  items: string[];
  buttonTitle: string;
  title: string;
}
