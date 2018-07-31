Shell

1 . 变量定义

    注意，变量名和等号之间不能有空格，这可能和你熟悉的所有编程语言都不一样。同时，变量名的命名须遵循如下规则：
    1.1 命名只能使用英文字母，数字和下划线，首个字符不能以数字开头。
    1.2 中间不能有空格，可以使用下划线（_）。
    1.3 不能使用标点符号。
    1.4 不能使用bash里的关键字（可用help命令查看保留关键字）。
    your_name="runoob.com"

2, 使用变量
    使用一个定义过的变量，只要在变量名前面加美元符号即可，如：

    your_name="qinjx"
    echo $your_name
    echo ${your_name}

    for skill in Ada Coffe Action Java; do
    echo "I am good at ${skill}Script"
    done

3. 只读变量
    使用 readonly 命令可以将变量定义为只读变量，只读变量的值不能被改变。
    #!/bin/bash
    myUrl="http://www.google.com"
    readonly myUrl
    myUrl="http://www.runoob.com"

4. 删除变量
    使用 unset 命令可以删除变量。语法：
    unset variable_name

5. 变量类型
    运行shell时，会同时存在三种变量：
    1) 局部变量 局部变量在脚本或命令中定义，仅在当前shell实例中有效，其他shell启动的程序不能访问局部变量。
    2) 环境变量 所有的程序，包括shell启动的程序，都能访问环境变量，有些程序需要环境变量来保证其正常运行。必要的时候shell脚本也可以定义环境变量。
    3) shell变量 shell变量是由shell程序设置的特殊变量。shell变量中有一部分是环境变量，有一部分是局部变量，这些变量保证了shell的正常运行

6. Shell 字符串
    1, 单引号
        str='this is a string'
        单引号字符串的限制：

        单引号里的任何字符都会原样输出，单引号字符串中的变量是无效的；
        单引号字串中不能出现单独一个的单引号（对单引号使用转义符后也不行），但可成对出现，作为字符串拼接使用。

    2. 双引号
        your_name='runoob'
        str="Hello, I know you are \"$your_name\"! \n"
        echo $str
        Hello, I know you are "runoob"!

        双引号的优点：
        双引号里可以有变量
        双引号里可以出现转义字符

7. 拼接字符串
        your_name="runoob"
        # 使用双引号拼接
        greeting="hello, "$your_name" !"
        greeting_1="hello, ${your_name} !"
        echo $greeting  $greeting_1
        # 使用单引号拼接
        greeting_2='hello, '$your_name' !'
        greeting_3='hello, ${your_name} !'
        echo $greeting_2  $greeting_3


8. 获取字符串长度
    string="abcd"
    echo ${#string} #输出 4


9. 提取子字符串
    以下实例从字符串第 2 个字符开始截取 4 个字符：

    string="runoob is a great site"
    echo ${string:1:4} # 输出 unoo
10. 查找子字符串
    查找字符 i 或 o 的位置(哪个字母先出现就计算哪个)：

    string="runoob is a great site"
    echo `expr index "$string" io`  # 输出 4

        数组
1， Shell 数组
    bash支持一维数组（不支持多维数组），并且没有限定数组的大小。
    类似与 C 语言，数组元素的下标由 0 开始编号。获取数组中的元素要利用下标，下标可以是整数或算术表达式，其值应大于或等于 0。
    1） 定义数组
        在 Shell 中，用括号来表示数组，数组元素用"空格"符号分割开。定义数组的一般形式为：

        数组名=(值1 值2 ... 值n)
        例如：

        array_name=(value0 value1 value2 value3)

    2）读取数组
        读取数组元素值的一般格式是：

        ${数组名[下标]}
        例如：

        valuen=${array_name[n]}
        使用 @ 符号可以获取数组中的所有元素，例如：

        echo ${array_name[@]}

2 ，获取数组的长度
        获取数组长度的方法与获取字符串长度的方法相同，例如：

        # 取得数组元素的个数
        length=${#array_name[@]}
        # 或者
        length=${#array_name[*]}
        # 取得数组单个元素的长度
        lengthn=${#array_name[n]}

        例如：
        arr_name=($your_name 1 2 3 4)

        echo " arr 个数 ：" ${#arr_name[@]}

        for val in ${arr_name[@]}
        do
        echo $val
        done

        for((i=0;i<${#arr_name[*]};i++));
        do
        echo ${arr_name[$i]}
        done


