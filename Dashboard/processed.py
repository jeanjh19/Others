import pandas as pd 
test1=pd.read_csv("/Users/huangjuetamaki/Desktop/clean_data_1.csv")
test1 = test1.index + 1
print(test1)
test1.to_csv('test1.csv')
