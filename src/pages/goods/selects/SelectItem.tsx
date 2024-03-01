import { FC, useRef, useState } from "react";
import style from "./SelectItem.module.css";
import { useMissClickSelect } from "./hooks/useMissClickSelect";
import { IBrandSelect } from "./interface";

export const SelectItem: FC<IBrandSelect> = ({
  getInfo,
  loadingSelect,
  setSelectInfo,
  items,
  title,
  buttonTitle,
}) => {
  const [inputValue, setInputValue] = useState("");
  const [isOpen, setIsOpen] = useState(false);
  const [filteredOptions, setFilteredOptions] = useState<string[]>(items);

  const handleInputChange = (e: string) => {
    const value = e.trim();
    setInputValue(value);
    const filtered = items.filter((option) => option.includes(value));
    setFilteredOptions(filtered);
    setIsOpen(filtered.length > 0);
    setSelectInfo(value);
  };
  const handleOptionClick = (value: string) => {
    setInputValue(value);
    setIsOpen(false);
    setSelectInfo(value);
  };

  const inputRef = useRef<HTMLDivElement>(null);

  useMissClickSelect(inputRef, isOpen, (isOpen) => setIsOpen(isOpen));

  return (
    <div>
      <h1>
        {title}
        {`(isLoading = ${loadingSelect})`}
      </h1>
      <div className={style.select} ref={inputRef}>
        <input
          type="text"
          value={inputValue}
          disabled={items.length === 0}
          onClick={() => !isOpen && handleInputChange(inputValue)}
          onChange={(e) => handleInputChange(e.currentTarget.value)}
          placeholder="Введите значение"
        />
        {isOpen && (
          <div className={style.selectItems}>
            {filteredOptions.map((option, index) => (
              <div
                key={index}
                className="select-item"
                onClick={() => handleOptionClick(option)}
              >
                {option}
              </div>
            ))}
          </div>
        )}
      </div>
      <button disabled={loadingSelect} onClick={() => getInfo()}>
        {buttonTitle}
      </button>
    </div>
  );
};
