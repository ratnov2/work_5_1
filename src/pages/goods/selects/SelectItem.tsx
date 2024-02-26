import { FC } from "react";

interface IBrandSelect {
  loadingSelect: boolean;
  getInfo: (type?: "left" | "right") => void;
  setSelectInfo: (e: string) => void;
  currentValueInSelect: string;
  items: string[];
  title: string;
  isEndPagination: boolean;
  offset: number;
}

export const SelectItem: FC<IBrandSelect> = ({
  getInfo,
  loadingSelect,
  currentValueInSelect,
  setSelectInfo,
  items,
  title,
  isEndPagination,
  offset,
}) => {
  return (
    <div>
      <h1>
        {title}
        {`(offset = ${offset})`}
        {`(isLoading = ${loadingSelect})`}
      </h1>
      <button disabled={loadingSelect} onClick={() => getInfo()}>
        Получить доступные бренды
      </button>
      <select
        onChange={(e) => setSelectInfo(e.currentTarget.value)}
        value={currentValueInSelect}
      >
        <option>Ничего не выбрано</option>
        {items.map((item: string, key) => (
          <option key={key}>{item}</option>
        ))}
      </select>
      <h3>Для загрузки дополнительных данных пролистайте дальше</h3>
      <div>
        <button
          disabled={offset === 0 || loadingSelect}
          onClick={() => {
            getInfo("left");
          }}
        >
          Click Left
        </button>
        <button
          disabled={isEndPagination || loadingSelect}
          onClick={() => {
            getInfo("right");
          }}
        >
          Click Right
        </button>
      </div>
    </div>
  );
};
