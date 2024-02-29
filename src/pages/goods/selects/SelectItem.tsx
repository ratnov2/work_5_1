import { FC, useState } from "react";

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
  const [inputValue, setInputValue] = useState("");
  const [selectedValue, setSelectedValue] = useState("");
  const handleChange = (e: any) => {
    setInputValue(e.target.value.trim().toLowerCase());
  };

  const handleSelectChange = (e: any) => {
    setSelectedValue(e.target.value);
  };

  const filteredData = items.filter((item) =>
    item.toLowerCase().includes(inputValue)
  );
  return (
    <div>
      <h1>
        {title}
        {`(offset = ${offset})`}
        {`(isLoading = ${loadingSelect})`}
      </h1>
      <input
        type="text"
        value={inputValue}
        onChange={handleChange}
        placeholder="Введите значение"
      />
      <button disabled={loadingSelect} onClick={() => getInfo()}>
        Получить доступные бренды
      </button>
      <select
        // onChange={(e) => setSelectInfo(e.currentTarget.value)}
        // value={currentValueInSelect}
        value={selectedValue}
        onChange={handleSelectChange}
      >
        <option>Ничего не выбрано</option>
        {filteredData.map((item: string, key) => (
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
